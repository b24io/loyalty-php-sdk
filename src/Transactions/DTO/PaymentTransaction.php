<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\DTO;

use B24io\Loyalty\SDK\Transport\DTO\OperationId;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use Money\Money;

/**
 * Class PaymentTransaction
 *
 * @package B24io\Loyalty\SDK\Transactions\DTO
 */
class PaymentTransaction extends AbstractTransaction
{
    /**
     * @param Money $value
     *
     * @return PaymentTransaction
     */
    public function setValue(Money $value): PaymentTransaction
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param OperationId $operationId
     *
     * @return PaymentTransaction
     */
    public function setOperationId(OperationId $operationId): PaymentTransaction
    {
        $this->operationId = $operationId;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return PaymentTransaction
     */
    public function setType(string $type): PaymentTransaction
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return PaymentTransaction
     */
    public function setCardNumber(int $cardNumber): PaymentTransaction
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param \DateTime $created
     *
     * @return PaymentTransaction
     */
    public function setCreated(\DateTime $created): PaymentTransaction
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return PaymentTransaction
     */
    public function setReason(Reason $reason): PaymentTransaction
    {
        $this->reason = $reason;

        return $this;
    }
}
