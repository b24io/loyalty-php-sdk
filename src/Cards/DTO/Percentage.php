<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO;

use Money\Money;

/**
 * Class Percentage
 *
 * @see     https://github.com/moneyphp/money/issues/482
 */
final class Percentage
{
    /**
     * @var string
     */
    private $percentage;

    /**
     * Percentage constructor.
     *
     * @param string $percentage
     * @param string $decimalSeparator
     */
    public function __construct(string $percentage, $decimalSeparator = '.')
    {
        if ($percentage !== '' && !is_numeric($percentage)) {
            throw new \InvalidArgumentException(sprintf('invalid vat percentage [%s]', $percentage));
        }
        // percentage string ends with $decimalSeparator? example: 5.
        if ((strpos($percentage, $decimalSeparator) !== false)
            && substr($percentage, strpos($percentage, $decimalSeparator)) === $decimalSeparator) {
            throw new \InvalidArgumentException(sprintf('invalid vat percentage [%s]', $percentage));
        }
        if ($percentage < 0) {
            throw new \InvalidArgumentException('percentage value must be positive');
        }

        // string without decimal part? example: 5 → 5.0
        if (strpos($percentage, $decimalSeparator) === false) {
            $percentage .= $decimalSeparator . '0';
        }
        // string with trailing zeros in end? examples:
        //  5.000000 → 5.0
        //  4.400000 → 4.4
        if (substr($percentage, strpos($percentage, $decimalSeparator)) !== '.0') {
            // strip trailing zeros
            $percentage = rtrim($percentage, '0');
            if (substr($percentage, -1) === $decimalSeparator) {
                $percentage .= '0';
            }
        }

        $this->percentage = $percentage;
    }

    /**
     * @return Percentage
     */
    public static function exempted(): Percentage
    {
        return new self('');
    }

    /**
     * @return Percentage
     */
    public static function zero(): Percentage
    {
        return new self('0');
    }

    /**
     * Checks whether the value represented by this object is less than the other.
     *
     * @param Percentage $other
     *
     * @return bool
     */
    public function lessThan(Percentage $other): bool
    {
        return $this->toRatio() < $other->toRatio();
    }

    /**
     * @return float|int
     */
    public function toRatio()
    {
        if ($this->percentage === '') {
            throw new \UnexpectedValueException('cannot return a ratio for an exempted vat percentage');
        }

        return $this->percentage / 100;
    }

    /**
     * Checks whether the value represented by this object is less than the other.
     *
     * @param Percentage $other
     *
     * @return bool
     */
    public function lessThanOrEqual(Percentage $other): bool
    {
        return $this->toRatio() <= $other->toRatio();
    }

    /**
     * @return bool
     */
    public function isExempted(): bool
    {
        return $this->percentage === '';
    }

    /**
     * @return bool
     */
    public function isZero(): bool
    {
        return $this->percentage === '0';
    }

    /**
     * @param Percentage $vatPercentage
     *
     * @return bool
     */
    public function equals(Percentage $vatPercentage): bool
    {
        return $this->percentage === $vatPercentage->percentage;
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    public function isSameValueAs(string $value): bool
    {
        return $this->percentage === $value;
    }

    /**
     * @param Money $amount
     *
     * @return Money
     */
    public function calculateInclusiveAmountFor(Money $amount): Money
    {
        return $amount->add($this->calculateVatFor($amount));
    }

    /**
     * @param Money $amount
     *
     * @return Money
     */
    public function calculateVatFor(Money $amount): Money
    {
        if ($this->percentage === '' || $amount->isZero()) {
            return new Money(0, $amount->getCurrency());
        }

        return $amount->multiply($this->percentage / 100, Money::ROUND_HALF_DOWN);
    }

    /**
     * @return string
     */
    public function format(): string
    {
        if ($this->percentage === '') {
            return '';
        }

        return $this->percentage . '%';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->percentage;
    }
}