<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperationWithCard;

/**
 * Class UnblockCard
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class UnblockCard extends AbstractOperationWithCard
{
    /**
     * @param string $operationCode
     *
     * @return UnblockCard
     */
    public function setOperationCode(string $operationCode): UnblockCard
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return UnblockCard
     */
    public function setCreated(\DateTime $timestamp): UnblockCard
    {
        $this->created = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return UnblockCard
     */
    public function setCardNumber(int $cardNumber): UnblockCard
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return UnblockCard
     */
    public function setReason(Reason $reason): UnblockCard
    {
        $this->reason = $reason;

        return $this;
    }
}