<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO\Values;

/**
 * Class AbstractValue
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO\Values
 */
abstract class AbstractValue
{
    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * AbstractValue constructor.
     *
     * @param \DateTime $timestamp
     */
    public function __construct(\DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return mixed
     */
    abstract public function getValue();
}