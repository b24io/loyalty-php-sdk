<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperationWithCard;
use Money\Money;

/**
 * Class ProcessPurchase
 *
 * @package B24io\Loyalty\SDK\Turnover\Operations
 */
class ProcessPurchase extends AbstractOperationWithCard
{
    /**
     * @var Money
     */
    protected $amount;

    /**
     * @param string $operationCode
     *
     * @return ProcessPurchase
     */
    public function setOperationCode(string $operationCode): ProcessPurchase
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return ProcessPurchase
     */
    public function setTimestamp(\DateTime $timestamp): ProcessPurchase
    {
        $this->created = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return ProcessPurchase
     */
    public function setCardNumber(int $cardNumber): ProcessPurchase
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return ProcessPurchase
     */
    public function setReason(Reason $reason): ProcessPurchase
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return Money
     */
    public function getAmount(): Money
    {
        return $this->amount;
    }

    /**
     * @param Money $amount
     *
     * @return ProcessPurchase
     */
    public function setAmount(Money $amount): ProcessPurchase
    {
        $this->amount = $amount;

        return $this;
    }
}