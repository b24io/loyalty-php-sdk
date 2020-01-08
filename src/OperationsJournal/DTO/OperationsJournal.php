<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO;

/**
 * Class OperationsJournal
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO
 */
final class OperationsJournal
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
     * @var OperationCollection
     */
    private $operations;

    /**
     * OperationsJournal constructor.
     *
     * @param \DateTime           $dateFrom
     * @param \DateTime           $dateTo
     * @param OperationCollection $operations
     */
    public function __construct(\DateTime $dateFrom, \DateTime $dateTo, OperationCollection $operations)
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->operations = $operations;
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
     * @return OperationCollection
     */
    public function getOperations(): OperationCollection
    {
        return $this->operations;
    }
}