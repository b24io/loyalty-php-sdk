<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperation;

/**
 * Class ChangePercentage
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class ChangePercentage extends AbstractOperation
{
    /**
     * @var Percentage
     */
    private $percentage;

    /**
     * @return Percentage
     */
    public function getPercentage(): Percentage
    {
        return $this->percentage;
    }

    /**
     * @param Percentage $percentage
     *
     * @return ChangePercentage
     */
    public function setPercentage(Percentage $percentage): ChangePercentage
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * @param string $operationCode
     *
     * @return ChangePercentage
     */
    public function setOperationCode(string $operationCode): ChangePercentage
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $timestamp
     *
     * @return ChangePercentage
     */
    public function setCreated(\DateTime $timestamp): ChangePercentage
    {
        $this->created = $timestamp;

        return $this;
    }

    /**
     * @param int $cardNumber
     *
     * @return ChangePercentage
     */
    public function setCardNumber(int $cardNumber): ChangePercentage
    {
        $this->cardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return ChangePercentage
     */
    public function setReason(Reason $reason): ChangePercentage
    {
        $this->reason = $reason;

        return $this;
    }
}