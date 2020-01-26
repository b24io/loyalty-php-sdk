<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\Formatters;

use B24io\Loyalty\SDK\Metrics;

/**
 * Class MetricValueCollection
 *
 * @package B24io\Loyalty\SDK\Metrics\Formatters
 */
class MetricValueCollection
{
    /**
     * @param Metrics\DTO\Metric                       $metric
     * @param Metrics\DTO\Values\MetricValueCollection $valueCollection
     *
     * @return array
     * @throws Metrics\Exceptions\UnknownMetricTypeException
     */
    public static function toArray(Metrics\DTO\Metric $metric, Metrics\DTO\Values\MetricValueCollection $valueCollection): array
    {
        $result = [];
        foreach ($valueCollection as $value) {
            $item = [];
            /**
             * @var Metrics\DTO\Values\AbstractValue $value
             */
            $item['timestamp'] = $value->getTimestamp()->format(\DATE_ATOM);
            switch ($metric->getType()) {
                case Metrics\DTO\MetricType::MONEY():
                    /**
                     * @var Metrics\DTO\Values\MoneyValue $value
                     */
                    $item['value'] = [
                        'amount'   => $value->getValue()->getAmount(),
                        'currency' => $value->getValue()->getCurrency()->getCode(),
                    ];
                    break;
                case Metrics\DTO\MetricType::INTEGER():
                case Metrics\DTO\MetricType::FLOAT():
                case Metrics\DTO\MetricType::PERCENTAGE():
                    $item['value'] = (string)$value->getValue();
                    break;
                default:
                    throw new Metrics\Exceptions\UnknownMetricTypeException(sprintf('unknown metric type [%s]', $metric->getType()->key()));
                    break;
            }
            $result[] = $item;
        }

        return $result;
    }
}