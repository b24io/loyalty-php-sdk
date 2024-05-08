<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Commands\Cards;

use B24io\Loyalty\SDK\Common\Formatters\Cards\CardItemFormatter;
use B24io\Loyalty\SDK\Common\Formatters\Cards\CardLevelItemFormatter;
use B24io\Loyalty\SDK\Common\Formatters\Contacts\ContactItemFormatter;
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

#[AsCommand(
    name: 'cards:export',
    description: 'Export loyalty cards to csv file')]
class ExportCards extends Command
{
    public function __construct(
        protected CardItemFormatter      $cardItemFormatter,
        protected CardLevelItemFormatter $cardLevelItemFormatter,
        protected ContactItemFormatter   $contactItemFormatter,
        protected LoggerInterface        $logger
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

    /**
     * @throws UnavailableStream
     * @throws CannotInsertRecord
     * @throws Exception
     * @throws BaseException
     */
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
        // add table header
        $writer->insertOne(
            array_merge(
                $this->cardItemFormatter->fields(),
                $this->cardLevelItemFormatter->fields(),
                $this->contactItemFormatter->fields()
            )
        );

        foreach ($admSb->cardsScope()->fetcher()->list() as $card) {
            $contact = array_fill(0, count($this->contactItemFormatter->fields()), null);
            if ($card->contact !== null) {
                //todo add external_id_key to cli arguments
                $contact = $this->contactItemFormatter->toFlatArray($card->contact, 'bitrix24');
            }

            $writer->insertOne(array_values(array_merge(
                $this->cardItemFormatter->toFlatArray($card),
                $this->cardLevelItemFormatter->toFlatArray($card->level),
                $contact)));

            $progressBar->advance();
        }
        $progressBar->finish();

        return Command::SUCCESS;
    }
}