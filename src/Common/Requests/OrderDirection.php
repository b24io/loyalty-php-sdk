<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Requests;

use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;

class OrderDirection
{
    private const asc = 'asc';
    private const desc = 'desc';
    private string $value;

    public function __construct(string $directionCode)
    {
        if (!in_array($directionCode, [self::asc, self::desc], true)) {
            throw new InvalidArgumentException(sprintf('Invalid direction code: %s', $directionCode));
        }
        $this->value = $directionCode;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(OrderDirection $direction): bool
    {
        return $this->value === (string)$direction;
    }

    public static function asc(): self
    {
        return new self(self::asc);
    }

    public static function desc(): self
    {
        return new self(self::desc);
    }

    public function isAsc(): bool
    {
        return $this->value === self::asc;
    }

    public function isDesc(): bool
    {
        return $this->value === self::desc;
    }
}