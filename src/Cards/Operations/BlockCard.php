<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperation;

/**
 * Class BlockCard
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class BlockCard extends AbstractOperation
{
    /**
     * @param string $operationCode
     *
     * @return BlockCard
     */
    public function setOperationCode(string $operationCode): BlockCard
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return BlockCard
     */
    public function setTimestamp(\DateTime $timestamp): BlockCard
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return BlockCard
     */
    public function setCardNumber(int $cardNumber): BlockCard
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return BlockCard
     */
    public function setReason(Reason $reason): BlockCard
    {
        $this->reason = $reason;

        return $this;
    }
}