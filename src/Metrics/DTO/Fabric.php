<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
use B24io\Loyalty\SDK\Metrics\DTO\Values\FloatValue;
use B24io\Loyalty\SDK\Metrics\DTO\Values\IntegerValue;
use B24io\Loyalty\SDK\Metrics\DTO\Values\MetricValueCollection;
use B24io\Loyalty\SDK\Metrics\DTO\Values\MoneyValue;
use B24io\Loyalty\SDK\Metrics\DTO\Values\PercentageValue;
use B24io\Loyalty\SDK\Metrics\Exceptions\UnknownMetricTypeException;
use Money\Currency;
use Money\Money;
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
            new MetricCode((string)$metric['code']),
            MetricType::memberByKey((string)$metric['type']),
            new \DateTime($metric['created'])
        );
    }

    /**
     * @param array $report
     *
     * @return Report
     * @throws \Exception
     */
    public static function initReportFromArray(array $report): Report
    {
        $metric = self::initMetricFromArray($report['metric']);

        return new Report(
            $metric,
            new \DateTime($report['date_from']),
            new \DateTime($report['date_to']),
            self::initMetricValueCollectionFromArray($metric, $report['values'])
        );
    }

    /**
     * @param Metric $metric
     * @param array  $metricValueCollection
     *
     * @return MetricValueCollection
     * @throws \Exception
     */
    public static function initMetricValueCollectionFromArray(Metric $metric, array $metricValueCollection): MetricValueCollection
    {
        $metricValues = new MetricValueCollection();

        foreach ($metricValueCollection as $item) {
            switch ($metric->getType()) {
                case MetricType::INTEGER():
                    $metricValues->attach(new IntegerValue((int)$item['value'], new \DateTime($item['timestamp'])));
                    break;
                case MetricType::FLOAT():
                    $metricValues->attach(new FloatValue((float)$item['value'], new \DateTime($item['timestamp'])));
                    break;
                case MetricType::PERCENTAGE():
                    $metricValues->attach(new PercentageValue(new Percentage((string)$item['value']), new \DateTime($item['timestamp'])));
                    break;
                case MetricType::MONEY():
                    $metricValues->attach(
                        new MoneyValue(
                            new Money((string)$item['value']['amount'], new Currency($item['value']['currency'])),
                            new \DateTime($item['timestamp'])
                        )
                    );
                    break;
                default:
                    throw new UnknownMetricTypeException(sprintf('unknown metric type [%s]', $metric->getType()->key()));
                    break;
            }
        }

        return $metricValues;
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