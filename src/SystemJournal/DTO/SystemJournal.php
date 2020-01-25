<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\DTO;

/**
 * Class SystemJournal
 *
 * @package B24io\Loyalty\SDK\SystemJournal\DTO
 */
class SystemJournal
{
    /**
     * @var \DateTime
     */
    private $dateFrom;
    /**
     * @var \DateTime
     */
    private $dateTo;
    /**
     * @var JournalItemCollection
     */
    private $items;

    /**
     * SystemJournal constructor.
     *
     * @param \DateTime             $dateFrom
     * @param \DateTime             $dateTo
     * @param JournalItemCollection $items
     */
    public function __construct(\DateTime $dateFrom, \DateTime $dateTo, JournalItemCollection $items)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->items = $items;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    /**
     * @return JournalItemCollection
     */
    public function getItems(): JournalItemCollection
    {
        return $this->items;
    }
}