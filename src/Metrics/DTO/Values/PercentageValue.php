<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO\Values;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;

/**
 * Class PercentageValue
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO\Values
 */
class PercentageValue extends AbstractValue
{
    /**
     * @var Percentage
     */
    private $value;

    /**
     * PercentageValue constructor.
     *
     * @param Percentage $value
     * @param \DateTime  $timestamp
     */
    public function __construct(Percentage $value, \DateTime $timestamp)
    {
        parent::__construct($timestamp);
        $this->value = $value;
    }

    /**
     * @return Percentage
     */
    public function getValue(): Percentage
    {
        return $this->value;
    }
}