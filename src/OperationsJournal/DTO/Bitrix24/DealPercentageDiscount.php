<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Bitrix24;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use \Money\Money;
use B24io\Loyalty\SDK\OperationsJournal\DTO\AbstractOperation;
use Ramsey\Uuid\UuidInterface;
use DateTime;

/**
 * Class DealPercentageDiscount
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\Bitrix24
 */
class DealPercentageDiscount extends AbstractOperation
{
    /**
     * @var Percentage
     */
    protected $percentage;
    /**
     * @var int
     */
    protected $dealId;

    /**
     * DealPercentageDiscount constructor.
     *
     * @param int           $bitrix24DealId
     * @param Percentage    $percentage
     * @param UuidInterface $uuid
     * @param UuidInterface $cardUuid
     * @param UserId        $userId
     * @param DateTime      $timestamp
     * @param Reason        $reason
     */
    public function __construct(
        int $bitrix24DealId,
        Percentage $percentage,
        UuidInterface $uuid,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        parent::__construct(
            $uuid,
            OperationType::BITRIX24_DEAL_PERCENTAGE_DISCOUNT_PAYMENT_TRANSACTION(),
            $cardUuid,
            $userId,
            $timestamp,
            $reason
        );
        $this->percentage = $percentage;
        $this->dealId = $bitrix24DealId;
    }

    /**
     * @return Percentage
     */
    public function getPercentage(): Percentage
    {
        return $this->percentage;
    }

    /**
     * @return int
     */
    public function getDealId(): int
    {
        return $this->dealId;
    }
}