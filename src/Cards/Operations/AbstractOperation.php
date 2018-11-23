<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;

/**
 * Class AbstractOperation
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
abstract class AbstractOperation
{
    /**
     * @var string
     */
    protected $operationCode;
    /**
     * @var \DateTime
     */
    protected $timestamp;
    /**
     * @var int
     */
    protected $cardNumber;
    /**
     * @var Reason
     */
    protected $reason;

    /**
     * @return string
     */
    public function getOperationCode(): string
    {
        return $this->operationCode;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return int
     */
    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }

    /**
     * @return Reason
     */
    public function getReason(): Reason
    {
        return $this->reason;
    }
}