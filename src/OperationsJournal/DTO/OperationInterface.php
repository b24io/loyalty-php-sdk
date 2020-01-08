<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO;

use B24io\Loyalty\SDK\Transport\DTO\OperationId;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Ramsey\Uuid\UuidInterface;

/**
 * Interface OperationInterface
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
interface OperationInterface
{
    /**
     * @return UuidInterface operation uuid
     */
    public function getUuid(): UuidInterface;

    /**
     * @return OperationType operation type
     */
    public function getOperationType(): OperationType;

    /**
     * @return UuidInterface
     */
    public function getCardUuid(): UuidInterface;

    /**
     * @return UserId card owner user id
     */
    public function getUserId(): UserId;

    /**
     * @return \DateTime operation timestamp
     */
    public function getTimestamp(): \DateTime;

    /**
     * @return Reason operation reason
     */
    public function getReason(): Reason;
}