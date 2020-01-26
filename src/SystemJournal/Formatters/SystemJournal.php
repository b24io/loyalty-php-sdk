<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\Formatters;

use \B24io\Loyalty\SDK\SystemJournal\DTO;

/**
 * Class SystemJournal
 *
 * @package B24io\Loyalty\SDK\SystemJournal\Formatters
 */
class SystemJournal
{
    /**
     * @param DTO\SystemJournal $systemJournal
     *
     * @return array
     */
    public static function toArray(DTO\SystemJournal $systemJournal): array
    {
        $arJournalItems = [];
        foreach ($systemJournal->getItems() as $item) {
            $arJournalItems[] = JournalItem::toArray($item);
        }

        return [
            'date_to'   => $systemJournal->getDateTo()->format(\DATE_RFC3339),
            'date_from' => $systemJournal->getDateFrom()->format(\DATE_RFC3339),
            'items'     => $arJournalItems,
        ];
    }
}