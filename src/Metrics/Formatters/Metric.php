<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\Formatters;

use B24io\Loyalty\SDK\Metrics;

/**
 * Class Metric
 *
 * @package B24io\Loyalty\SDK\Metrics\Formatters
 */
class Metric
{
    /**
     * @param Metrics\DTO\Metric $metric
     *
     * @return array
     */
    public static function toArray(Metrics\DTO\Metric $metric): array
    {
        return [
            'name'        => $metric->getName(),
            'description' => $metric->getDescription(),
            'code'        => $metric->getCode()->getValue(),
            'type'        => $metric->getType()->key(),
            'created'     => $metric->getCreated()->format(\DATE_ATOM),
            'uuid'        => $metric->getUuid()->toString(),
        ];
    }
}