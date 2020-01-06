<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\Transport\DTO;

use B24io\Loyalty\SDK\Metrics\DTO\MetricCollection;
use B24io\Loyalty\SDK\Transport\DTO\AbstractResponse;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class MetricCollectionResponse
 *
 * @package B24io\Loyalty\SDK\Metrics\Transport\DTO
 */
class MetricCollectionResponse extends AbstractResponse
{
    /**
     * @var MetricCollection
     */
    protected $metricCollection;

    /**
     * MetricCollectionResponse constructor.
     *
     * @param MetricCollection $metricCollection
     * @param Metadata         $metadata
     */
    public function __construct(MetricCollection $metricCollection, Metadata $metadata)
    {
        parent::__construct($metadata);
        $this->metricCollection = $metricCollection;
    }

    /**
     * @return MetricCollection
     */
    public function getMetricCollection(): MetricCollection
    {
        return $this->metricCollection;
    }
}