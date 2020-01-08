<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use DateTime;
use Ramsey\Uuid\UuidInterface;

/**
 * Class AbstractOperation
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
abstract class AbstractOperation implements OperationInterface
{
    /**
     * @var UuidInterface
     */
    protected $uuid;
    /**
     * @var OperationType
     */
    protected $operationType;
    /**
     * @var UuidInterface
     */
    protected $cardUuid;
    /**
     * @var UserId
     */
    protected $userId;
    /**
     * @var DateTime
     */
    protected $timestamp;
    /**
     * @var Reason
     */
    protected $reason;

    /**
     * AbstractOperation constructor.
     *
     * @param UuidInterface $uuid
     * @param OperationType $operationType
     * @param UuidInterface $cardUuid
     * @param UserId        $userId
     * @param DateTime      $timestamp
     * @param Reason        $reason
     */
    public function __construct(
        UuidInterface $uuid,
        OperationType $operationType,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        $this->uuid = $uuid;
        $this->operationType = $operationType;
        $this->cardUuid = $cardUuid;
        $this->userId = $userId;
        $this->timestamp = $timestamp;
        $this->reason = $reason;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return OperationType
     */
    public function getOperationType(): OperationType
    {
        return $this->operationType;
    }

    /**
     * @return UuidInterface
     */
    public function getCardUuid(): UuidInterface
    {
        return $this->cardUuid;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return DateTime
     */
    public function getTimestamp(): DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return Reason
     */
    public function getReason(): Reason
    {
        return $this->reason;
    }
}