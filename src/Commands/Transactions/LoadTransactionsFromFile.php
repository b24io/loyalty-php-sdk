<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Core\Exceptions\FileUnavailableException;
use B24io\Loyalty\SDK\Infrastructure\Filesystem\TransactionsReader;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use DateTime;
use Generator;
use InvalidArgumentException;
use League\Csv\Writer;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Parser\DecimalMoneyParser;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Helper\ProgressBar;
use Throwable;

#[AsCommand(
    name: 'transactions:load-from-file',
    description: 'Process transactions from csv file' . PHP_EOL .
    'file columns:' . PHP_EOL .
    '   card_number - card number, example: 12345' . PHP_EOL .
    '   transaction_amount - bonus amount, example: 245.65' . PHP_EOL .
    '   transaction_type - accrual or payment transaction, example: accrual' . PHP_EOL .
    '   reason_id - unique reason id per client transaction list, example: gift2024.04.25' . PHP_EOL .
    '   reason_code -  reason code, example: marketingGiftProgram ' . PHP_EOL .
    '   reason_comment - reason comment for user, example: Spring gift! We double your bonuses!'
)]
class LoadTransactionsFromFile extends Command
{
    public function __construct(
        private readonly TransactionsReader    $transactionsReader,
        private readonly DecimalMoneyFormatter $decimalMoneyFormatter,
        private readonly LoggerInterface       $logger
    )
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
            'file',
            null,
            InputOption::VALUE_REQUIRED,
            'file with transactions in csv format');
        $this->addOption(
            'skip-check',
            null,
            InputOption::VALUE_OPTIONAL,
            'skip check via api-call «get-transactions-by-card» is transaction already processed',
            false
        );
        $this->addOption(
            'skip-check',
            null,
            InputOption::VALUE_OPTIONAL,
            'skip check via api-call «get-transactions-by-card» is transaction already processed',
            false
        );
        $this->addOption(
            'offset',
            null,
            InputOption::VALUE_OPTIONAL,
            'skip «offset» transactions from file, and start with offset+1',
            0
        );

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Process transactions from input file with transactions log',
            '============',
            '',
        ]);

        $apiEndpointUrl = $input->getOption('api-endpoint-url');
        if ($apiEndpointUrl === null) {
            $output->writeln('error: you must set api-endpoint-url option');

            return Command::INVALID;
        }

        $apiClientId = $input->getOption('api-client-id');
        if ($apiClientId === null) {
            $output->writeln('error: you must set api-client-id option');

            return Command::INVALID;
        }

        $apiAdminKey = $input->getOption('api-admin-key');
        if ($apiAdminKey === null) {
            $output->writeln('error: you must set api-admin-key option');

            return Command::INVALID;
        }

        $filename = $input->getOption('file');
        if ($filename === null) {
            $output->writeln('error: you must set file option');

            return Command::INVALID;
        }

        $filesystem = new Filesystem();
        if (!$filesystem->exists($filename)) {
            $output->writeln(sprintf('error: file %s not found', $filename));

            return Command::INVALID;
        }

        $isSkipCheckIsTransactionAlreadyProcessed = false;
        $skipCheckTrxValue = $input->getOption('skip-check');
        if ($skipCheckTrxValue === null || $skipCheckTrxValue === true) {
            $isSkipCheckIsTransactionAlreadyProcessed = true;
        }

        $offsetTrxCount = 0;
        $offsetTrxCountValue = $input->getOption('offset');
        if (is_numeric($offsetTrxCountValue)) {
            $offsetTrxCount = (int)$offsetTrxCountValue;
        }

        $admSb = ServiceBuilderFactory::createAdminRoleServiceBuilder(
            $apiEndpointUrl,
            $apiClientId,
            $apiAdminKey,
            $this->logger
        );

        // src/Commands/Transactions
        $baseFolder = dirname(__DIR__, 3) . '/';
        /**
         * @var array{'extension':string,'filename':string} $pathInfo
         */
        $pathInfo = pathinfo((string) $filename);

        $totalTransactionsInFile = $this->transactionsReader->countTransactionsInFile($filename);
        $output->writeln(sprintf('transactions count %s in file %s', $totalTransactionsInFile, $filename));

        $failureTrxFilename = sprintf('failure_%s_%s.%s', (new DateTime())->format('YmdHis'), $pathInfo['filename'], $pathInfo['extension']);
        $revokedTrxFilename = sprintf('revoked_%s_%s.%s', (new DateTime())->format('YmdHis'), $pathInfo['filename'], $pathInfo['extension']);
        $processedTrxFilename = sprintf('processed_%s_%s.%s', (new DateTime())->format('YmdHis'), $pathInfo['filename'], $pathInfo['extension']);

        $output->writeln([
            'start processing transactions, results stored in files:',
            sprintf('   %s contains failed transcactions', $failureTrxFilename),
            sprintf('   %s contains revoked transactions, eg already processed before current run', $revokedTrxFilename),
            sprintf('   %s contains processed transactions', $processedTrxFilename),
            '',
            sprintf('is skip check transaction already processed: %s', $isSkipCheckIsTransactionAlreadyProcessed ? 'Y' : 'N'),
            sprintf('offset transactions in file: %s', $offsetTrxCount)
        ]);

        $failureTrxLog = Writer::createFromPath($baseFolder . $failureTrxFilename, 'w+');
        $failureTrxLog->insertOne(['card_id', 'card_number', 'transaction_type', 'transaction_amount', 'transaction_iso_currency_code', 'error_message']);

        $revokedTrxLog = Writer::createFromPath($baseFolder . $revokedTrxFilename, 'w+');
        $revokedTrxLog->insertOne(['card_id', 'card_number', 'transaction_type', 'transaction_amount', 'transaction_iso_currency_code', 'comment', 'transaction_id', 'transaction_created_at']);

        $processedTrxLog = Writer::createFromPath($baseFolder . $processedTrxFilename, 'w+');
        $processedTrxLog->insertOne(['card_id', 'card_number', 'transaction_type', 'transaction_amount', 'transaction_iso_currency_code', 'transaction_id']);

        $progressBar = new ProgressBar($output, $totalTransactionsInFile);
        $progressBar->setFormat("%current%/%max% [%bar%] %percent:3s%%\n  %estimated:-21s% %memory:21s%\ninfo: %status%\n");
        $status = 'started...';
        $progressBar->setMessage($status, 'status');

        foreach ($this->transactionsReader->loadTransactionsByCardNumber($filename) as $cnt => $newTrx) {
            // skip processed transactions
            if (($offsetTrxCount > 0) && $offsetTrxCount > $cnt) {
                $progressBar->advance();
                continue;
            }
            try {
                // check is transaction already processed
                if (!$isSkipCheckIsTransactionAlreadyProcessed) {
                    // get transactions for current card and check is new transaction already processed
                    $existsTrx = $admSb->transactionsScope()->transactions()->getByCardNumber($newTrx->cardNumber)->getTransactions();
                    foreach ($existsTrx as $t) {
                        if ($t->reason->equal($newTrx->reason)) {
                            $this->logger->warning('LoadTransactionsFromFile.transactionAlreadyProcessed', [
                                'cardNumber' => $newTrx->cardNumber
                            ]);
                            $status = sprintf('transaction type %s with amount %s for card %s number already processed',
                                $newTrx->type->value,
                                $this->decimalMoneyFormatter->format($newTrx->amount),
                                $newTrx->cardNumber,
                            );
                            $progressBar->setMessage($status, 'status');
                            $progressBar->advance();

                            $revokedTrxLog->insertOne([
                                $newTrx->cardId->toRfc4122(),
                                $newTrx->cardNumber,
                                $newTrx->type->value,
                                $this->decimalMoneyFormatter->format($newTrx->amount),
                                $newTrx->amount->getCurrency()->getCode(),
                                'транзакция уже проведена',
                                $t->id->toRfc4122(),
                                $t->created->format(DATE_ATOM),
                            ]);

                            continue 2;
                        }
                    }
                }

                switch ($newTrx->type) {
                    case TransactionType::accrual:
                        $resTrx = $admSb->transactionsScope()->transactions()->processAccrualTransactionByCardNumber(
                            $newTrx->cardNumber,
                            $newTrx->amount,
                            $newTrx->reason
                        );

                        $status = sprintf('accrual transaction %s processed - %s', $resTrx->getTransaction()->id, $resTrx->getTransaction()->value->getAmount());

                        break;
                    case TransactionType::payment:
                        $resTrx = $admSb->transactionsScope()->transactions()->processPaymentTransactionByCardNumber(
                            $newTrx->cardNumber,
                            $newTrx->amount,
                            $newTrx->reason
                        );

                        $status = sprintf('payment transaction %s processed - %s', $resTrx->getTransaction()->id, $resTrx->getTransaction()->value->getAmount());
                        break;
                }
                // write to processed file
                $processedTrxLog->insertOne([
                        $newTrx->cardId->toRfc4122(),
                        $newTrx->cardNumber,
                        $newTrx->type->value,
                        $this->decimalMoneyFormatter->format($newTrx->amount),
                        $newTrx->amount->getCurrency()->getCode(),
                        $resTrx->getTransaction()->id->toRfc4122(),
                    ]
                );
            } catch (Throwable $exception) {
                $this->logger->error('LoadTransactionsFromFile.processItem.error', [
                    'message' => $exception->getMessage()
                ]);
                $failureTrxLog->insertOne([
                    $newTrx->cardId->toRfc4122(),
                    $newTrx->cardNumber,
                    $newTrx->type->value,
                    $this->decimalMoneyFormatter->format($newTrx->amount),
                    $newTrx->amount->getCurrency()->getCode(),
                    $exception->getMessage()
                ]);
            }
            $progressBar->setMessage($status, 'status');
            $progressBar->advance();
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }
}