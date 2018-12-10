<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperation;

/**
 * Class AddCard
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class AddCard extends AbstractOperation
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @param UserId $userId
     *
     * @return AddCard
     */
    public function setUserId(UserId $userId): AddCard
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @param string $operationCode
     *
     * @return AddCard
     */
    public function setOperationCode(string $operationCode): AddCard
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return AddCard
     */
    public function setCreated(\DateTime $timestamp): AddCard
    {
        $this->created = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return AddCard
     */
    public function setCardNumber(int $cardNumber): AddCard
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return AddCard
     */
    public function setReason(Reason $reason): AddCard
    {
        $this->reason = $reason;

        return $this;
    }
}