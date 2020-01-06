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
     * Card constructor.
     *
     * @param int             $number
     * @param string          $barcode
     * @param StatusInterface $status
     * @param User            $user
     * @param Money           $balance
     * @param Percentage      $percentage
     * @param \DateTime       $created
     * @param \DateTime       $modified
     * @param UuidInterface   $uuid
     */
    public function __construct(
        int $number,
        string $barcode,
        StatusInterface $status,
        User $user,
        Money $balance,
        Percentage $percentage,
        \DateTime $created,
        \DateTime $modified,
        UuidInterface $uuid
    ) {
        $this->number = $number;
        $this->barcode = $barcode;
        $this->status = $status;
        $this->user = $user;
        $this->balance = $balance;
        $this->percentage = $percentage;
        $this->created = $created;
        $this->modified = $modified;
        $this->uuid = $uuid;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getBarcode(): string
    {
        return $this->barcode;
    }

    /**
     * @return StatusInterface
     */
    public function getStatus(): StatusInterface
    {
        return $this->status;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Money
     */
    public function getBalance(): Money
    {
        return $this->balance;
    }

    /**
     * @return Percentage
     */
    public function getPercentage(): Percentage
    {
        return $this->percentage;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }
}