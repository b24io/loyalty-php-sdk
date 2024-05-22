<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Infrastructure\Filesystem;

use B24io\Loyalty\SDK\Common\Requests\Transactions\ProcessTransactionByCardNumber;
use Generator;
use InvalidArgumentException;
use League\Csv\Exception;
use League\Csv\SyntaxError;
use League\Csv\UnavailableStream;
use Psr\Log\LoggerInterface;
use League\Csv;

class TransactionsReader
{
    /**
     * @readonly
     */
    private LoggerInterface $log;
    /**
     * @var array<int|string>
     * @readonly
     */
    private array $transactionByCardNumberFileHeader;

    public function __construct(
        LoggerInterface $log
    )
    {
        $this->log = $log;
        $this->transactionByCardNumberFileHeader = [
            'card_id',
            'card_number',
            'transaction_type',
            'transaction_amount',
            'transaction_iso_currency_code',
            'transaction_reason_id',
            'transaction_reason_code',
            'transaction_reason_comment',
            'contact_id',
            'contact_external_id',
        ];
    }

    /**
     * @param array<int, string> $headerColumns
     * @return void
     */
    private function validateHeader(array $headerColumns): void
    {
        // check header columns
        foreach ($this->transactionByCardNumberFileHeader as $headerColumn) {
            if (!in_array($headerColumn, $headerColumns, true)) {
                throw new InvalidArgumentException(sprintf('column «%s» not found, expected columns: %s', $headerColumn,
                    implode(', ', $this->transactionByCardNumberFileHeader)
                ));
            }
        }
    }

    /**
     * @throws UnavailableStream
     * @throws SyntaxError
     * @throws Exception
     */
    public function countTransactionsInFile(string $fileName): int
    {
        $reader = Csv\Reader::createFromPath($fileName);
        $reader->setHeaderOffset(0);

        $this->validateHeader($reader->getHeader());
        return $reader->count();
    }

    /**
     * @param string $fileName
     * @return Generator<ProcessTransactionByCardNumber>
     * @throws InvalidArgumentException
     * @throws SyntaxError
     * @throws Exception
     */
    public function loadTransactionsByCardNumber(string $fileName): Generator
    {
        $this->log->debug('loadTransactionsByCardNumber.start', [
            'fileName' => $fileName
        ]);

        $reader = Csv\Reader::createFromPath($fileName);
        $reader->setHeaderOffset(0);

        $this->validateHeader($reader->getHeader());
        $records = $reader->getRecords();
        foreach ($records as $offset => $recordItem) {
            $this->log->debug('loadTransactionsByCardNumber.itemRow', ['offset' => $offset]);
            /**
             * @var array{'card_id':string, 'card_number':string, 'transaction_amount':string, 'transaction_iso_currency_code':non-empty-string, 'transaction_type': non-empty-string, 'contact_id':non-empty-string, 'contact_external_id':string, 'transaction_reason_id':non-empty-string,'transaction_reason_code':non-empty-string,'transaction_reason_comment':string } $recordItem
             */
            yield ProcessTransactionByCardNumber::initFromArray($recordItem);
        }

        $this->log->debug('loadTransactionsByCardNumber.finish');
    }
}