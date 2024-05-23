<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Cards;

use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;

class CardStatus
{
    private const active = 'active';
    private const blocked = 'blocked';
    private const deleted = 'deleted';
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $cardStatusCode)
    {
        if (!in_array($cardStatusCode, [self::active, self::blocked, self::deleted])) {
            throw new InvalidArgumentException(sprintf('invalid card status code: %s', $cardStatusCode));
        }
        $this->value = $cardStatusCode;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function active(): self
    {
        return new self(self::active);
    }

    public static function blocked(): self
    {
        return new self(self::blocked);
    }

    public static function deleted(): self
    {
        return new self(self::deleted);
    }

    public function equals(CardStatus $cardStatus): bool
    {
        return $this->value === (string)$cardStatus;
    }

    public function isActive(): bool
    {
        return $this->value === self::active;
    }

    public function isDeleted(): bool
    {
        return $this->value === self::active;
    }

    public function isBlocked(): bool
    {
        return $this->value === self::active;
    }
}