<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO;

use B24io\Loyalty\SDK\Cards\DTO\Statuses\StatusInterface;

use B24io\Loyalty\SDK\Users\DTO\User;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Card
 *
 * @package B24io\Loyalty\SDK\Cards\DTO
 */
final class Card
{
    /**
     * @var int
     */
    private $number;
    /**
     * @var string
     */
    private $barcode;
    /**
     * @var StatusInterface
     */
    private $status;
    /**
     * @var User
     */
    private $user;
    /**
     * @var Money
     */
    private $balance;
    /**
     * @var Percentage
     */
    private $percentage;
    /**
     * @var \DateTime
     */
    private $created;
    /**
     * @var \DateTime
     */
    private $modified;
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @param UuidInterface $uuid
     *
     * @return Card
     */
    public function setUuid(UuidInterface $uuid): Card
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @param int $number
     *
     * @return Card
     */
    public function setNumber(int $number): Card
    {
        $this->number = $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @param string $barcode
     *
     * @return Card
     */
    public function setBarcode(string $barcode): Card
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface
    {
        return $this->status;
    }

    /**
     * @param StatusInterface $status
     *
     * @return Card
     */
    public function setStatus(StatusInterface $status): Card
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return Card
     */
    public function setUser(User $user): Card
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Money
     */
    public function getBalance(): Money
    {
        return $this->balance;
    }

    /**
     * @param Money $balance
     *
     * @return Card
     */
    public function setBalance(Money $balance): Card
    {
        $this->balance = $balance;

        return $this;
    }

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
     * @return Card
     */
    public function setPercentage(Percentage $percentage): Card
    {
        $this->percentage = $percentage;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return Card
     */
    public function setCreated(\DateTime $created): Card
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * @param \DateTime $modified
     *
     * @return Card
     */
    public function setModified(\DateTime $modified): Card
    {
        $this->modified = $modified;

        return $this;
    }
}