<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands\Cards;

use League\Csv\Writer;
use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use Generator;
use InvalidArgumentException;
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
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'cards:export',
    description: 'Export loyalty cards to csv file')]
class ExportCards extends Command
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
            'file to store cards');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Export cards to output csv file',
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
            $this->logger,
            $apiEndpointUrl,
            $apiClientId,
            $apiAdminKey
        );

        $cardsTotal = $admSb->cardsScope()->cards()->count();
        $progressBar = new ProgressBar($output, $cardsTotal);

        $writer = Writer::createFromPath($filename, 'w+');
        $writer->insertOne([
            'card_id',
            'card_number',
            'card_status',
            'card_barcode',
            'card_amount',
            'card_iso_currency_code',
            'card_created',
            'card_modified',
            'contact_external_id',
            'contact_name',
            'contact_surname',
            'contact_patronymic',
        ]);

        $decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        foreach ($admSb->cardsScope()->fetcher()->list() as $cnt => $card) {
            $cardItem = [
                'card_id' => $card->id->toRfc4122(),
                'card_number' => $card->number,
                'card_status' => $card->status->name,
                'card_barcode' => $card->barcode,
                'card_amount' => $decimalMoneyFormatter->format($card->balance),
                'card_iso_currency_code' => $card->balance->getCurrency()->getCode(),
                'card_created' => $card->created->format(DATE_ATOM),
                'card_modified' => $card->modified->format(DATE_ATOM),
                // todo add to options
                'contact_external_id' => $card->contact->externalIds['bitrix24'],
                'contact_name' => $card->contact->fullName->name,
                'contact_surname' => $card->contact->fullName->surname,
                'contact_patronymic' => $card->contact->fullName->patronymic
            ];
            $writer->insertOne(array_values($cardItem));
            $progressBar->advance();
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }
}