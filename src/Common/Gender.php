<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;

class Gender
{
    private const male = 'male';
    private const female = 'female';
    private const unknown = 'unknown';
    private string $value;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $genderCode)
    {
        if (!in_array($genderCode, [self::male, self::female, self::unknown])) {
            throw new InvalidArgumentException(sprintf('Gender code "%s" is not valid', $genderCode));
        }
        $this->value = $genderCode;
    }

    public function __toString()
    {
        return $this->value;
    }

    public static function male(): self
    {
        return new self(self::male);
    }

    public static function female(): self
    {
        return new self(self::female);
    }

    public static function unknown(): self
    {
        return new self(self::unknown);
    }

    public function equals(self $gender): bool
    {
        return $this->value === (string)$gender;
    }

    public function isMale(): bool
    {
        return $this->value === self::male;
    }

    public function isFemale(): bool
    {
        return $this->value === self::female;
    }

    public function isUnknown(): bool
    {
        return $this->value === self::unknown;
    }
}