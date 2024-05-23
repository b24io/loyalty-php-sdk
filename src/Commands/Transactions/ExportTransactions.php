<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands\Transactions;

use B24io\Loyalty\SDK\Common\Formatters\Cards\CardItemFormatter;
use B24io\Loyalty\SDK\Common\Formatters\Cards\CardLevelItemFormatter;
use B24io\Loyalty\SDK\Common\Formatters\Contacts\ContactItemFormatter;
use B24io\Loyalty\SDK\Common\Formatters\Transactions\TransactionItemFormatter;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use League\Csv\CannotInsertRecord;
use League\Csv\Exception;
use League\Csv\UnavailableStream;
use League\Csv\Writer;
use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ExportTransactions extends Command
{
    protected TransactionItemFormatter $transactionItemFormatter;
    protected LoggerInterface $logger;
    protected static $defaultName = 'transactions:export';
    protected static $defaultDescription = 'Export transactions to csv file';
    public function __construct(
        TransactionItemFormatter $transactionItemFormatter,
        LoggerInterface          $logger)
    {
        $this->transactionItemFormatter = $transactionItemFormatter;
        $this->logger = $logger;
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
            'file to store transactions');
    }
    /**
     * @throws UnavailableStream
     * @throws CannotInsertRecord
     * @throws Exception
     * @throws BaseException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Export transactions to output csv file',
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
        if ($filesystem->exists($filename)) {
            $output->writeln(sprintf('error: file %s already exists', $filename));

            return Command::INVALID;
        }

        $admSb = ServiceBuilderFactory::createAdminRoleServiceBuilder(
            $apiEndpointUrl,
            $apiClientId,
            $apiAdminKey,
            $this->logger
        );

        $trxTotal = $admSb->transactionsScope()->transactions()->count();
        $progressBar = new ProgressBar($output, $trxTotal);

        $writer = Writer::createFromPath($filename, 'w+');
        // add table header
        $writer->insertOne($this->transactionItemFormatter->fields());

        foreach ($admSb->transactionsScope()->fetcher()->list() as $trx) {
            $writer->insertOne(array_values($this->transactionItemFormatter->toFlatArray($trx)));
            $progressBar->advance();
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }
}