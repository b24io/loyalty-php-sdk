<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO\Values;

/**
 * Class IntegerValue
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO\Values
 */
class IntegerValue extends AbstractValue
{
    /**
     * @var int
     */
    private $value;

    /**
     * IntegerValue constructor.
     *
     * @param int       $value
     * @param \DateTime $timestamp
     */
    public function __construct(int $value, \DateTime $timestamp)
    {
        parent::__construct($timestamp);
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}