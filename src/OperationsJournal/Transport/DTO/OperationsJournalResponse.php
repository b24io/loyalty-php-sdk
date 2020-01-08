<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Transport\DTO;

use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationsJournal;
use B24io\Loyalty\SDK\Transport\DTO\AbstractResponse;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class OperationsJournalResponse
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Transport\DTO
 */
class OperationsJournalResponse extends AbstractResponse
{
    /**
     * @var OperationsJournal
     */
    protected $operationsJournal;

    /**
     * OperationsJournalResponse constructor.
     *
     * @param OperationsJournal $operationsJournal
     * @param Metadata          $metadata
     */
    public function __construct(OperationsJournal $operationsJournal, Metadata $metadata)
    {
        parent::__construct($metadata);
        $this->operationsJournal = $operationsJournal;
    }

    /**
     * @return OperationsJournal
     */
    public function getOperationsJournal(): OperationsJournal
    {
        return $this->operationsJournal;
    }
}