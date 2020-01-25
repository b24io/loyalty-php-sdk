<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\Transport\DTO;

use B24io\Loyalty\SDK\SystemJournal\DTO\SystemJournal;
use B24io\Loyalty\SDK\Transport\DTO\AbstractResponse;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class SystemJournalResponse
 *
 * @package B24io\Loyalty\SDK\SystemJournal\Transport\DTO
 */
class SystemJournalResponse extends AbstractResponse
{
    /**
     * @var SystemJournal
     */
    protected $systemJournal;

    /**
     * SystemJournalResponse constructor.
     *
     * @param SystemJournal $systemJournal
     * @param Metadata      $metadata
     */
    public function __construct(SystemJournal $systemJournal, Metadata $metadata)
    {
        parent::__construct($metadata);
        $this->systemJournal = $systemJournal;
    }

    /**
     * @return SystemJournal
     */
    public function getSystemJournal(): SystemJournal
    {
        return $this->systemJournal;
    }
}