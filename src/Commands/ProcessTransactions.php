<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use Generator;
use InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Parser\DecimalMoneyParser;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'transactions:process',
    description: 'Process transactions from csv file')]
class ProcessTransactions extends Command
{
    public function __construct(
        protected LoggerInterface $logger
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
            'file in csv format with transactions log');
        $this->addOption(
            'currency',
            null,
            InputOption::VALUE_REQUIRED,
            'fallback ISO currency code');

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

        $currency = $input->getOption('currency');
        if ($currency === null) {
            $output->writeln('error: you must set currency option');

            return Command::INVALID;
        }
        $currency = new Currency($currency);

        $admSb = ServiceBuilderFactory::createAdminRoleServiceBuilder(
            $this->logger,
            $apiEndpointUrl,
            $apiClientId,
            $apiAdminKey
        );

        // load card in memory
        // todo add progress bar
        $cards = $this->loadCards($admSb);

        foreach ($this->loadTransactionsFromFile($filename, $currency) as $row) {
               // todo pass zero trx

            if (!array_key_exists($row['phone'], $cards)) {
                $output->writeln(sprintf('warning: card %s not found', $row['phone']));
                continue;
            }

            // get transactions for current card
            $trx = $admSb->transactions()->getByCardNumber($row['phone'])->getTransactions();
            foreach ($trx as $t) {
                if ($t->reason->equal($row['reason'])) {
                    continue 2;
                }
            }

            if ($row['type'] === TransactionType::accrual) {
                $res = $admSb->transactions()->processAccrualTransactionByCardNumber(
                    $row['phone'],
                    $row['amount'],
                    $row['reason']
                );

                $output->writeln(sprintf('accrual transaction %s processed - %s', $res->getTransaction()->id, $res->getTransaction()->value->getAmount()));
            }
        }

        return Command::SUCCESS;
    }

    private function loadCards(AdminServiceBuilder $adminServiceBuilder): array
    {
        $res = $adminServiceBuilder->cards()->list();

        $cards = $res->getCards();
        $pages = $res->getCoreResponse()->getResponseData()->pagination->pages;

        for ($i = 1; $i <= $pages; $i++) {
            $res = $adminServiceBuilder->cards()->list($i);
            $cards = array_merge($cards, $res->getCards());
        }

        // index by number column
        return array_column($cards, null, 'number');
    }

    private function loadTransactionsFromFile(string $file, Currency $currency): Generator
    {
        $moneyParser = new DecimalMoneyParser(new ISOCurrencies());

        $handle = fopen($file, 'rb');
        for ($i = 0; $row = fgetcsv($handle, null, ';'); ++$i) {
            if ($i === 0) {
                // check headers
                if (!in_array('phone', $row, true)) {
                    throw new InvalidArgumentException('phone column header not found in first row in file');
                }
                if (!in_array('amount', $row, true)) {
                    throw new InvalidArgumentException('amount column header not found in first row in file');
                }
                if (!in_array('type', $row, true)) {
                    throw new InvalidArgumentException('type column header not found in first row in file');
                }

                continue;
            }

            // todo add position validation
            yield [
                'phone' => $row[0],
                'amount' => $moneyParser->parse($row[1], $currency),
                'type' => TransactionType::from($row[2]),
                'reason' => new Reason(
                    'admin',
                    'import',
                    'import data from file'
                )
            ];
        }
        fclose($handle);
    }
}