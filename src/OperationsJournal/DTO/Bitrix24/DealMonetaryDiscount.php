<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Bitrix24;

use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use \Money\Money;
use B24io\Loyalty\SDK\OperationsJournal\DTO\AbstractOperation;
use Ramsey\Uuid\UuidInterface;
use DateTime;

/**
 * Class DealMonetaryDiscount
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\Bitrix24
 */
class DealMonetaryDiscount extends AbstractOperation
{
    /**
     * @var Money
     */
    protected $value;
    /**
     * @var int
     */
    protected $dealId;

    /**
     * DealMonetaryDiscount constructor.
     *
     * @param int           $bitrix24DealId
     * @param Money         $value
     * @param UuidInterface $uuid
     * @param UuidInterface $cardUuid
     * @param UserId        $userId
     * @param DateTime      $timestamp
     * @param Reason        $reason
     */
    public function __construct(
        int $bitrix24DealId,
        Money $value,
        UuidInterface $uuid,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        parent::__construct(
            $uuid,
            OperationType::BITRIX24_DEAL_MONETARY_DISCOUNT_PAYMENT_TRANSACTION(),
            $cardUuid,
            $userId,
            $timestamp,
            $reason
        );
        $this->value = $value;
        $this->dealId = $bitrix24DealId;
    }

    /**
     * @return Money
     */
    public function getValue(): Money
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getDealId(): int
    {
        return $this->dealId;
    }
}