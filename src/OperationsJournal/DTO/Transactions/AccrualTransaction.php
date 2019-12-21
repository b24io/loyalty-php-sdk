<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions;

use B24\Loyalty;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Money\Money;
use Ramsey\Uuid\UuidInterface;
use DateTime;

/**
 * Class AccrualTransaction
 *
 * @package B24\Loyalty\Operations\DTO\Transactions
 */
final class AccrualTransaction extends AbstractTransaction
{
    /**
     * AbstractTransaction constructor.
     *
     * @param Money         $value
     * @param UuidInterface $uuid
     * @param UuidInterface $cardUuid
     * @param UserId        $userId
     * @param DateTime      $timestamp
     * @param Reason        $reason
     */
    public function __construct(
        Money $value,
        UuidInterface $uuid,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        parent::__construct($value, $uuid, OperationType::ACCRUAL_TRANSACTION(), $cardUuid, $userId, $timestamp, $reason);
    }
}