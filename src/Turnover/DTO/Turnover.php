<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\DTO;

use Money\Money;

/**
 * Class Turnover
 *
 * @package B24io\Loyalty\SDK\Turnover\DTO
 */
class Turnover
{
    /**
     * @var \DateTime
     */
    private $modified;
    /**
     * @var Money
     */
    private $totalPurchasesSum;
    /**
     * @var int
     */
    private $totalPurchasesCount;

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * @param \DateTime $modified
     *
     * @return Turnover
     */
    public function setModified(\DateTime $modified): Turnover
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @return Money
     */
    public function getTotalPurchasesSum(): Money
    {
        return $this->totalPurchasesSum;
    }

    /**
     * @param Money $totalPurchasesSum
     *
     * @return Turnover
     */
    public function setTotalPurchasesSum(Money $totalPurchasesSum): Turnover
    {
        $this->totalPurchasesSum = $totalPurchasesSum;

        return $this;
    }

    /**
     * @return int
     */
    public function getTotalPurchasesCount(): int
    {
        return $this->totalPurchasesCount;
    }

    /**
     * @param int $totalPurchasesCount
     *
     * @return Turnover
     */
    public function setTotalPurchasesCount(int $totalPurchasesCount): Turnover
    {
        $this->totalPurchasesCount = $totalPurchasesCount;

        return $this;
    }
}