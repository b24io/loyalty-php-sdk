<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO;

use B24io\Loyalty\SDK\Metrics\Exceptions\InvalidMetricCodeException;

/**
 * Class MetricCode
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO
 */
class MetricCode
{
    /**
     * @var string
     */
    private $value;

    /**
     * MetricCode constructor.
     *
     * @param string $value
     *
     * @throws InvalidMetricCodeException
     */
    public function __construct(string $value)
    {
        if ($value === '') {
            throw new InvalidMetricCodeException('metric code cant be empty string');
        }
        if (strlen($value) > 255) {
            throw new InvalidMetricCodeException(sprintf('metric code [%s] length must be smaller then 255 symbols', $value));
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}