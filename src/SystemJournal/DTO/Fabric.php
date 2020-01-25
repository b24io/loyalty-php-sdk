<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\DTO;

use Ramsey\Uuid\Uuid;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\SystemJournal\DTO
 */
class Fabric
{
    /**
     * @param array $systemJournalItem
     *
     * @return JournalItem
     * @throws \Exception
     */
    public static function initJournalItemFromArray(array $systemJournalItem): JournalItem
    {
        return new JournalItem(
            new \DateTime((string)$systemJournalItem['timestamp']),
            LogLevel::memberByKey((string)$systemJournalItem['level'], false),
            (string)$systemJournalItem['message'],
            (string)$systemJournalItem['source'],
            Uuid::fromString((string)$systemJournalItem['event_uuid'])
        );
    }

    /**
     * @param array $systemJournal
     *
     * @return SystemJournal
     * @throws \Exception
     */
    public static function initSystemJournalFromArray(array $systemJournal): SystemJournal
    {
        $journalItems = new JournalItemCollection();
        foreach ($systemJournal['items'] as $item) {
            $journalItems->attach(self::initJournalItemFromArray($item));
        }

        return new SystemJournal(
            new \DateTime((string)$systemJournal['date_from']),
            new \DateTime((string)$systemJournal['date_to']),
            $journalItems
        );
    }
}