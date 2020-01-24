<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO\Values;

use Money\Money;

/**
 * Class MoneyValue
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO\Values
 */
class MoneyValue extends AbstractValue
{
    /**
     * @var Money
     */
    private $value;

    /**
     * MoneyValue constructor.
     *
     * @param Money     $value
     * @param \DateTime $timestamp
     */
    public function __construct(Money $value, \DateTime $timestamp)
    {
        parent::__construct($timestamp);
        $this->value = $value;
    }

    /**
     * @return Money
     */
    public function getValue(): Money
    {
        return $this->value;
    }
}