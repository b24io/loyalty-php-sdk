<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;

class TransactionType
{
    private string $value;
    private const accrual = 'accrual';
    private const payment = 'payment';

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $value)
    {
        if (!in_array($value, [self::accrual, self::payment], true)) {
            throw new InvalidArgumentException(sprintf('invalid transaction type code «%s» you must use %s or %s',
                $value,
                self::payment,
                self::accrual
            ));
        }
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isEqual(self $transactionType): bool
    {
        return $this->value === (string)$transactionType;
    }

    public static function payment(): self
    {
        return new self(self::payment);
    }

    public static function accrual(): self
    {
        return new self(self::accrual);
    }
}