<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO;

use Ramsey\Uuid\Uuid;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO
 */
class Fabric
{
    /**
     * @param array $metric
     *
     * @return Metric
     * @throws \Exception
     */
    public static function initMetricFromArray(array $metric): Metric
    {
        return new Metric(
            Uuid::fromString($metric['uuid']),
            (string)$metric['name'],
            (string)$metric['description'],
            (string)$metric['code'],
            MetricType::memberByKey((string)$metric['type']),
            new \DateTime($metric['created'])
        );
    }

    /**
     * @param array $metricCollection
     *
     * @return MetricCollection
     * @throws \Exception
     */
    public static function initMetricCollectionFromArray(array $metricCollection): MetricCollection
    {
        $metrics = new MetricCollection();
        foreach ($metricCollection as $item) {
            $metrics->attach(self::initMetricFromArray($item));
        }

        return $metrics;
    }
}