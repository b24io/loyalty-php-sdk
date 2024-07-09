<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;

class VerificationStatus
{
    private const unverified = 'unverified';
    private const verified = 'verified';
    private const in_process = 'in_process';
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $verificationStatus)
    {
        $allowed = [self::unverified, self::verified, self::in_process];
        if (!in_array($verificationStatus, $allowed)) {
            throw new InvalidArgumentException(sprintf('unknown verification status %s, use one of %s', $verificationStatus, implode(', ', $allowed)));
        }
        $this->value = $verificationStatus;
    }

    public function __toString()
    {
        return $this->value;
    }

    public static function unverified(): self
    {
        return new self(self::unverified);
    }

    public static function verified(): self
    {
        return new self(self::verified);
    }

    public static function inProcess(): self
    {
        return new self(self::in_process);
    }

    public function equals(self $status): bool
    {
        return $this->value === (string)$status;
    }

    public function isUnverified(): bool
    {
        return $this->value === self::unverified;
    }

    public function isVerified(): bool
    {
        return $this->value === self::verified;
    }

    public function isInProcess(): bool
    {
        return $this->value === self::in_process;
    }
}