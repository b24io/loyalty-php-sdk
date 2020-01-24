<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\Formatters;

use B24io\Loyalty\SDK\Metrics;

/**
 * Class Report
 *
 * @package B24io\Loyalty\SDK\Metrics\Formatters
 */
class Report
{
    /**
     * @param Metrics\DTO\Report $report
     *
     * @return array
     * @throws Metrics\Exceptions\UnknownMetricTypeException
     */
    public static function toArray(Metrics\DTO\Report $report): array
    {
        return [
            'metric'    => Metric::toArray($report->getMetric()),
            'date_from' => $report->getDateFrom()->format(\DATE_RFC3339),
            'date_to'   => $report->getDateTo()->format(\DATE_RFC3339),
            'values'    => MetricValueCollection::toArray($report->getMetric(), $report->getValues()),
        ];
    }
}