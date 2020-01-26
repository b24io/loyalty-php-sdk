<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO\Values;

/**
 * Class FloatValue
 *
 * @package B24\Loyalty\Metrics\DTO\Values
 */
class FloatValue extends AbstractValue
{
    /**
     * @var float
     */
    private $value;

    /**
     * FloatValue constructor.
     *
     * @param float     $value
     * @param \DateTime $timestamp
     */
    public function __construct(float $value, \DateTime $timestamp)
    {
        parent::__construct($timestamp);
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }
}