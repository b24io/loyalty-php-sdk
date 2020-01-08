<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions;

use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use \Money\Money;
use B24io\Loyalty\SDK\OperationsJournal\DTO\AbstractOperation;
use Ramsey\Uuid\UuidInterface;
use DateTime;

/**
 * Class AbstractTransaction
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions
 */
abstract class AbstractTransaction extends AbstractOperation implements TransactionInterface
{
    /**
     * @var Money
     */
    protected $value;

    /**
     * AbstractTransaction constructor.
     *
     * @param Money         $value
     * @param UuidInterface $uuid
     * @param OperationType $operationType
     * @param UuidInterface $cardUuid
     * @param UserId        $userId
     * @param DateTime      $timestamp
     * @param Reason        $reason
     */
    public function __construct(
        Money $value,
        UuidInterface $uuid,
        OperationType $operationType,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        parent::__construct($uuid, $operationType, $cardUuid, $userId, $timestamp, $reason);
        $this->value = $value;
    }

    /**
     * @return Money
     */
    public function getValue(): Money
    {
        return $this->value;
    }
}