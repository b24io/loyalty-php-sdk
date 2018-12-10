<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\DTO;

use B24io\Loyalty\SDK\Transport\DTO\OperationId;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use Money\Money;

/**
 * Class AccrualTransaction
 *
 * @package B24io\Loyalty\SDK\Transactions\DTO
 */
class AccrualTransaction extends AbstractTransaction
{
    /**
     * @param Money $value
     *
     * @return AccrualTransaction
     */
    public function setValue(Money $value): AccrualTransaction
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param OperationId $operationId
     *
     * @return AccrualTransaction
     */
    public function setOperationId(OperationId $operationId): AccrualTransaction
    {
        $this->operationId = $operationId;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return AccrualTransaction
     */
    public function setType(string $type): AccrualTransaction
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return AccrualTransaction
     */
    public function setCardNumber(int $cardNumber): AccrualTransaction
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param \DateTime $created
     *
     * @return AccrualTransaction
     */
    public function setCreated(\DateTime $created): AccrualTransaction
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return AccrualTransaction
     */
    public function setReason(Reason $reason): AccrualTransaction
    {
        $this->reason = $reason;

        return $this;
    }
}
