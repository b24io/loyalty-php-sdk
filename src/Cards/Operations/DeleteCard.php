<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperationWithCard;

/**
 * Class DeleteCard
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class DeleteCard extends AbstractOperationWithCard
{
    /**
     * @param string $operationCode
     *
     * @return DeleteCard
     */
    public function setOperationCode(string $operationCode): DeleteCard
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return DeleteCard
     */
    public function setCreated(\DateTime $timestamp): DeleteCard
    {
        $this->created = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return DeleteCard
     */
    public function setCardNumber(int $cardNumber): DeleteCard
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return DeleteCard
     */
    public function setReason(Reason $reason): DeleteCard
    {
        $this->reason = $reason;

        return $this;
    }
}