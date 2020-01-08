<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Purchases;

use B24io\Loyalty\SDK\OperationsJournal\DTO\AbstractOperation;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use B24io\Loyalty\SDK\Transport\DTO\PurchaseId;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Money\Money;
use Ramsey\Uuid\UuidInterface;
use DateTime;

/**
 * Class Purchase
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\Purchases
 */
final class Purchase extends AbstractOperation
{
    /**
     * @var Money
     */
    private $sum;
    /**
     * @var PurchaseId
     */
    private $purchaseId;

    /**
     * Purchase constructor.
     *
     * @param Money         $purchaseSum
     * @param UuidInterface $uuid
     * @param UuidInterface $cardUuid
     * @param UserId        $userId
     * @param DateTime      $timestamp
     * @param Reason        $reason
     */
    public function __construct(
        Money $purchaseSum,
        UuidInterface $uuid,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        parent::__construct($uuid, OperationType::PURCHASE(), $cardUuid, $userId, $timestamp, $reason);
        $this->sum = $purchaseSum;
        $this->purchaseId = new PurchaseId($reason->getId());
    }

    /**
     * @return Money
     */
    public function getSum(): Money
    {
        return $this->sum;
    }

    /**
     * @return PurchaseId
     */
    public function getPurchaseId(): PurchaseId
    {
        return $this->purchaseId;
    }
}