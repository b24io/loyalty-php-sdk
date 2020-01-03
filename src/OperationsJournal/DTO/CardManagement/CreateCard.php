<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement;

use B24io\Loyalty\SDK\OperationsJournal\DTO\AbstractOperation;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use DateTime;
use Ramsey\Uuid\UuidInterface;

/**
 * Class CreateCard
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement
 */
class CreateCard extends AbstractOperation
{
    public function __construct(
        UuidInterface $uuid,
        UuidInterface $cardUuid,
        UserId $userId,
        DateTime $timestamp,
        Reason $reason
    ) {
        parent::__construct($uuid, OperationType::CREATE_CARD(), $cardUuid, $userId, $timestamp, $reason);
    }
}