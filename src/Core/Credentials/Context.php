<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Credentials;

use B24io\Loyalty\SDK\Core\Exceptions;
use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;

class Context
{
    /**
     * @var string
     */
    private string $value;
    private const admin = 'admin';
    private const user = 'user';
    private const default = '';

    /**
     * @param string $value
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!in_array($value, [self::admin, self::user, self::default], true)) {
            throw new Exceptions\InvalidArgumentException(sprintf('invalid context type «%s»', $value));
        }
        $this->value = $value;
    }

    public function isDefault(): bool
    {
        return $this->value === self::default;
    }

    public function isUser(): bool
    {
        return $this->value === self::user;
    }

    public function isAdmin(): bool
    {
        return $this->value === self::admin;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function equals(Context $context): bool
    {
        return $this->value === (string)$context;
    }
}