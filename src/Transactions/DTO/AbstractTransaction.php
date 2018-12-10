<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\DTO;

use B24io\Loyalty\SDK\Transport\DTO\OperationId;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use \Money\Money;

/**
 * Class AbstractTransaction
 *
 * @package B24\Loyalty\Transactions\DTO
 */
abstract class AbstractTransaction implements TransactionInterface
{
    /**
     * @var Money
     */
    protected $value;
    /**
     * @var OperationId
     */
    protected $operationId;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var int
     */
    protected $cardNumber;
    /**
     * @var \DateTime
     */
    protected $created;
    /**
     * @var Reason
     */
    protected $reason;

    /**
     * @return Reason
     */
    public function getReason(): Reason
    {
        return $this->reason;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return Money
     */
    public function getValue(): Money
    {
        return $this->value;
    }

    /**
     * @return OperationId
     */
    public function getOperationId(): OperationId
    {
        return $this->operationId;
    }

    /**
     * @return int
     */
    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }
}