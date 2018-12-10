<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperation;
use Money\Money;

/**
 * Class ProcessPurchase
 *
 * @package B24io\Loyalty\SDK\Turnover\Operations
 */
class ProcessAccrualTransaction extends AbstractOperation
{
    /**
     * @var Money
     */
    protected $value;

    /**
     * @return Money
     */
    public function getValue(): Money
    {
        return $this->value;
    }

    /**
     * @param Money $value
     *
     * @return ProcessAccrualTransaction
     */
    public function setValue(Money $value): ProcessAccrualTransaction
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $operationCode
     *
     * @return ProcessAccrualTransaction
     */
    public function setOperationCode(string $operationCode): ProcessAccrualTransaction
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return ProcessAccrualTransaction
     */
    public function setTimestamp(\DateTime $timestamp): ProcessAccrualTransaction
    {
        $this->created = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return ProcessAccrualTransaction
     */
    public function setCardNumber(int $cardNumber): ProcessAccrualTransaction
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return ProcessAccrualTransaction
     */
    public function setReason(Reason $reason): ProcessAccrualTransaction
    {
        $this->reason = $reason;

        return $this;
    }
}