<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands\Transactions;

use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

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
            'type',
            null,
            InputOption::VALUE_REQUIRED,
            'transaction type: accrual or payment');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Bulk operations with active cards',
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

        $admSb = ServiceBuilderFactory::createAdminRoleServiceBuilder(
            $this->logger,
            $apiEndpointUrl,
            $apiClientId,
            $apiAdminKey
        );

        $cardsTotal = $admSb->cardsScope()->cards()->count();
        $progressBar = new ProgressBar($output, $cardsTotal);

        foreach ($admSb->cardsScope()->fetcher()->list() as $card) {
            $progressBar->advance();
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }
}