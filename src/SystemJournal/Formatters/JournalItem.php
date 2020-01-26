<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\Formatters;

use \B24io\Loyalty\SDK\SystemJournal;

/**
 * Class JournalItem
 *
 * @package B24io\Loyalty\SDK\SystemJournal\Formatters
 */
class JournalItem
{
    /**
     * @param SystemJournal\DTO\JournalItem $journalItem
     *
     * @return array
     */
    public static function toArray(SystemJournal\DTO\JournalItem $journalItem): array
    {
        return [
            'message'    => $journalItem->getMessage(),
            'level'      => $journalItem->getLevel()->key(),
            'timestamp'  => $journalItem->getTimestamp()->format(\DATE_RFC3339),
            'source'     => $journalItem->getSource(),
            'event_uuid' => $journalItem->getEventUuid()->toString(),
        ];
    }
}