<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\Transport\DTO;

use B24io\Loyalty\SDK\Metrics\DTO\Report;
use B24io\Loyalty\SDK\Transport\DTO\AbstractResponse;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class MetricReportResponse
 *
 * @package B24io\Loyalty\SDK\Metrics\Transport\DTO
 */
class MetricReportResponse extends AbstractResponse
{
    /**
     * @var Report
     */
    protected $report;

    /**
     * MetricCollectionResponse constructor.
     *
     * @param Report   $report
     * @param Metadata $metadata
     */
    public function __construct(Report $report, Metadata $metadata)
    {
        parent::__construct($metadata);
        $this->report = $report;
    }

    /**
     * @return Report
     */
    public function getReport(): Report
    {
        return $this->report;
    }
}