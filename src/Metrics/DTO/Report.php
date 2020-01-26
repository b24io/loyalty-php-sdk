<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO;

use B24io\Loyalty\SDK\Metrics\DTO\Values\MetricValueCollection;

/**
 * Class Report
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO
 */
class Report
{
    /**
     * @var Metric
     */
    private $metric;
    /**
     * @var \DateTime
     */
    private $dateFrom;
    /**
     * @var \DateTime
     */
    private $dateTo;
    /**
     * @var MetricValueCollection
     */
    private $values;

    /**
     * Report constructor.
     *
     * @param Metric                $metric
     * @param \DateTime             $dateFrom
     * @param \DateTime             $dateTo
     * @param MetricValueCollection $values
     */
    public function __construct(Metric $metric, \DateTime $dateFrom, \DateTime $dateTo, MetricValueCollection $values)
    {
        $this->metric = $metric;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
        $this->values = $values;
    }

    /**
     * @return Metric
     */
    public function getMetric(): Metric
    {
        return $this->metric;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    /**
     * @return MetricValueCollection
     */
    public function getValues(): MetricValueCollection
    {
        return $this->values;
    }
}