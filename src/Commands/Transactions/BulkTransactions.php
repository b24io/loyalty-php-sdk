<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
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
    name: 'transactions:bulk-transaction',
    description: 'Bulk accrual or payment transaction to all active cards')]
class BulkTransactions extends Command
{
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
            'transaction-type',
            null,
            InputOption::VALUE_REQUIRED,
            'transaction type: accrual or payment');
        $this->addOption(
            'amount',
            null,
            InputOption::VALUE_REQUIRED,
            'transaction amount'
        );
        $this->addOption(
            'currency',
            null,
            InputOption::VALUE_REQUIRED,
            'ISO currency code'
        );
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
            'dryrun',
            null,
            InputOption::VALUE_NONE,
            'validate input and show information',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Apply transaction to all active cards',
            '============',
            '',
        ]);
        $io = new SymfonyStyle($input, $output);
        $decimalMoneyParser = new DecimalMoneyParser(new ISOCurrencies());
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

        $transactionType = TransactionType::tryFrom((string)$input->getOption('transaction-type'));
        if ($transactionType === null) {
            $io->error('you must set «transaction-type» option: «accrual» or «payment»');

            return Command::INVALID;
        }

        $currency = $input->getOption('currency');
        if ($currency === null) {
            $io->error('you must set «currency» option, use ISO-currency codes');

            return Command::INVALID;
        }
        $currency = new Currency($currency);

        $amount = $input->getOption('amount');
        if ($amount === null) {
            $io->error('you must set «amount» option');

            return Command::INVALID;
        }
        $amount = $decimalMoneyParser->parse($amount, $currency);

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
        $isDryrun = $input->getOption('dryrun');


        // add result trx log

        $admSb = ServiceBuilderFactory::createAdminRoleServiceBuilder(
            $apiEndpointUrl,
            $apiClientId,
            $apiAdminKey,
            $this->logger
        );
        $cardsTotal = $admSb->cardsScope()->cards()->count();
        $io->info([
            '',
            sprintf('amount: %s', $decimalMoneyFormatter->format($amount)),
            sprintf('cards affected: %s', $cardsTotal),
            sprintf('reason code: %s', $reasonCode),
            sprintf('reason comment: %s', $reasonComment),
        ]);

        $progressBar = new ProgressBar($output, $cardsTotal);
        foreach ($admSb->cardsScope()->fetcher()->list() as $card) {
            try {
                if ($isDryrun) {
                    $io->note(['', 'dry run mode is active', '']);
                    break;
                }

                $trxHistoryByCard = $admSb->transactionsScope()->transactions()->getByCardNumber($card->number);
                $reasonCodeHistory = array_map(static function (Reason $reason) {
                    return $reason->code;
                }, array_column($trxHistoryByCard->getTransactions(), 'reason'));
                if (in_array($reasonCode, $reasonCodeHistory, true)) {
                    $this->logger->info(sprintf('transaction already processed for card %s', $card->number));
                    continue;
                }

                $trxResult = $admSb->transactionsScope()->transactions()->processAccrualTransactionByCardNumber(
                    $card->number,
                    $amount,
                    new Reason(
                        'loyalty-php-sdk',
                        $reasonCode,
                        $reasonComment
                    )
                );
                $this->logger->info(
                    sprintf('transaction for card %s processed', $card->number),
                    [
                        'trxId' => $trxResult->getTransaction()->id->toRfc4122()
                    ]
                );
            } catch (Throwable $exception) {
                $io->error([
                    '',
                    $exception->getMessage(),
                    $exception->getTraceAsString()
                ]);
            }

            $progressBar->advance();
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }
}