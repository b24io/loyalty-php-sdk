<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use DateTime;
use DateTimeInterface;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'transactions:burn-bonuses',
    description: 'Burning of bonuses accrued before the specified date')]
class BurnBonuses extends Command
{
    private const string REASON_ID = 'b24io.loyalty.sdk.cli.util';

    public function __construct(private LoggerInterface $logger)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'api-endpoint-url',
            null,
            InputOption::VALUE_REQUIRED,
            'API endpoint URL',
        );
        $this->addOption(
            'api-client-id',
            null,
            InputOption::VALUE_REQUIRED,
            'API client id from application settings');
        $this->addOption(
            'api-admin-key',
            null,
            InputOption::VALUE_REQUIRED,
            'API admin key from application settings');
        $this->addOption(
            'reason-code',
            null,
            InputOption::VALUE_REQUIRED,
            'reason code'
        );
        $this->addOption(
            'reason-comment',
            null,
            InputOption::VALUE_REQUIRED,
            'reason comment'
        );
        $this->addOption(
            'date',
            null,
            InputOption::VALUE_REQUIRED,
            'Burn bonuses accrued before this date in format dd.mm.YYYY',
        );
        $this->addOption(
            'dryrun',
            null,
            InputOption::VALUE_NONE,
            'validate input and show information',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Burning of bonuses accrued before the specified date',
            '============',
            '',
        ]);
        $io = new SymfonyStyle($input, $output);
        $decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        $apiEndpointUrl = $input->getOption('api-endpoint-url');
        if ($apiEndpointUrl === null) {
            $io->error('you must set «api-endpoint-url» option');

            return Command::INVALID;
        }

        $apiClientId = $input->getOption('api-client-id');
        if ($apiClientId === null) {
            $io->error('you must set «api-client-id» option');

            return Command::INVALID;
        }

        $apiAdminKey = $input->getOption('api-admin-key');
        if ($apiAdminKey === null) {
            $io->error('you must set «api-admin-key» option');

            return Command::INVALID;
        }

        $reasonCode = $input->getOption('reason-code');
        if ($reasonCode === null) {
            $io->error('you must set «reason-code» option');

            return Command::INVALID;
        }

        $reasonComment = $input->getOption('reason-comment');
        if ($reasonComment === null) {
            $io->error('you must set «reason-comment» option');

            return Command::INVALID;
        }
        $isDryRun = $input->getOption('dryrun');
        $rawBurnoutDate = $input->getOption('date');
        if ($rawBurnoutDate === null) {
            $io->error('you must set «date» option in format dd.mm.YYYY');

            return Command::INVALID;
        }
        $burnoutDate = DateTime::createFromFormat('d.m.Y', $rawBurnoutDate);
        if(!$burnoutDate){
            $io->error('you must set valid «date» option in format dd.mm.YYYY');

            return Command::INVALID;
        }

        $admSb = ServiceBuilderFactory::createAdminRoleServiceBuilder($apiEndpointUrl, $apiClientId, $apiAdminKey, $this->logger);
        $cardsTotal = $admSb->cardsScope()->cards()->count();

        $io->info([
            '',
            sprintf('cards total: %s', $cardsTotal),
            sprintf('reason code: %s', $reasonCode),
            sprintf('reason comment: %s', $reasonComment),
            sprintf('burnout date: %s', $burnoutDate->format('d.m.Y')),
        ]);
        if ($isDryRun) {
            $io->note(['', 'dry run mode is active', '']);
        }

        $progressBar = new ProgressBar($output, $cardsTotal);
        foreach ($admSb->cardsScope()->fetcher()->list() as $cnt => $card) {
            $progressBar->advance();
            try {
                // filter cards with balance > 0
                if ($card->balance->isZero()) {
                    $output->write(sprintf('%s - %s | card %s balance is 0', $cnt, $cardsTotal, $card->number), true);
                    continue;
                }

                // get last 50 transactions for current card
                $trxHistoryByCard = $admSb->transactionsScope()->transactions()->getByCardNumber($card->number);
                $reasonCodeHistory = array_map(static function (Reason $reason) {
                    return $reason->code;
                }, array_column($trxHistoryByCard->getTransactions(), 'reason'));

                // if trx with reason-code exists, pass card
                if (in_array($reasonCode, $reasonCodeHistory, true)) {
                    $output->write(sprintf('%s - %s | card %s is processed, balance %s', $cnt, $cardsTotal, $card->number, $decimalMoneyFormatter->format($card->balance)), true);
                    $this->logger->info(sprintf('transaction already processed for card %s', $card->number));
                    continue;
                }
                $output->writeln('');
                $output->write(sprintf('%s - %s | %s | %s | trx cnt %s',
                    $cnt, $cardsTotal, $card->number, $decimalMoneyFormatter->format($card->balance),
                    count($trxHistoryByCard->getTransactions())), true);

                // calculate burn bonuses sum
                $trxSumAfterBurnDate = $this->sumAccrualTransactionsAfterDate($output, $admSb, $card->number, $burnoutDate, $card->balance->getCurrency());
                if ($trxSumAfterBurnDate->isZero()) {
                    // we don't have an accrual transactions after burn date, burn all bonuses
                    $burnSum = $card->balance;
                } else {
                    $burnSum = $card->balance->subtract($trxSumAfterBurnDate);
                }
                // burn bonuses
                if ($burnSum->isPositive()) {
                    $paymentTrx = $admSb->transactionsScope()->transactions()->processPaymentTransactionByCardNumber(
                        $card->number,
                        $burnSum,
                        new Reason(self::REASON_ID, $reasonCode, $reasonComment))->getTransaction();

                    $output->write(sprintf('burn %s bonuses from card %s',
                        $decimalMoneyFormatter->format($paymentTrx->value),
                        $card->number
                    ), true);
                }
            } catch (Throwable $exception) {
                $io->error([
                    '',
                    $exception->getMessage(),
                    $exception->getTraceAsString()
                ]);
                exit();
            }
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }

    private function sumAccrualTransactionsAfterDate(
        OutputInterface     $output,
        AdminServiceBuilder $adminServiceBuilder,
        string              $cardNumber,
        DateTimeInterface   $burnDate,
        Currency            $defaultCurrency
    ): Money
    {
        $totalSum = new Money(0, $defaultCurrency);
        foreach ($adminServiceBuilder->transactionsScope()->fetcher()->listByCardNumber($cardNumber) as $trxItem) {
            if ($burnDate < $trxItem->created && $trxItem->type === TransactionType::accrual) {
                $totalSum = $totalSum->add($trxItem->value);
            }
        }
        return $totalSum;
    }
}