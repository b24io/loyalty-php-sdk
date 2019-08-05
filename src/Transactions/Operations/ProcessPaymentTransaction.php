<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperationWithCard;
use Money\Money;

/**
 * Class ProcessPaymentTransaction
 *
 * @package B24io\Loyalty\SDK\Turnover\Operations
 */
class ProcessPaymentTransaction extends AbstractOperationWithCard
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
     * @return ProcessPaymentTransaction
     */
    public function setValue(Money $value): ProcessPaymentTransaction
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param string $operationCode
     *
     * @return ProcessPaymentTransaction
     */
    public function setOperationCode(string $operationCode): ProcessPaymentTransaction
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return ProcessPaymentTransaction
     */
    public function setTimestamp(\DateTime $timestamp): ProcessPaymentTransaction
    {
        $this->created = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return ProcessPaymentTransaction
     */
    public function setCardNumber(int $cardNumber): ProcessPaymentTransaction
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return ProcessPaymentTransaction
     */
    public function setReason(Reason $reason): ProcessPaymentTransaction
    {
        $this->reason = $reason;

        return $this;
    }
}