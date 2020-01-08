<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
use B24io\Loyalty\SDK\OperationsJournal\DTO\AbstractOperation;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Ramsey\Uuid\UuidInterface;
use DateTime;

/**
 * Class IncrementPercent
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges
 */
final class IncrementPercent extends AbstractOperation implements PercentRateChangeOperationInterface
{
    /**
     * @var Percentage
     */
    private $percentage;

    /**
     * DecrementPercent constructor.
     *
     * @param Percentage    $percentage
     * @param UuidInterface $uuid
     * @param UuidInterface $cardUuid
     * @param UserId        $userId
     * @param DateTime      $timestamp
     * @param Reason        $reason
     */
    public function __construct(
        Percentage $percentage,
        UuidInterface $uuid,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        parent::__construct($uuid, OperationType::INCREMENT_PERCENT(), $cardUuid, $userId, $timestamp, $reason);
        $this->percentage = $percentage;
    }

    /**
     * @return Percentage
     */
    public function getPercentage(): Percentage
    {
        return $this->percentage;
    }
}