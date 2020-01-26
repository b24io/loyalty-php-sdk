<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Metrics;

use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Turnover\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @return SDK\Metrics\Transport\DTO\MetricCollectionResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getMetricCollection(): SDK\Metrics\Transport\DTO\MetricCollectionResponse
    {
        $this->log->debug('b24io.loyalty.sdk.Metrics.transport.admin.getMetricCollection.start');

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                'admin/metrics/?%s',
                http_build_query(
                    [
                        self::CLIENT_API_KEY => $this->apiClient->getAuthToken()->getClientApiKey()->toString(),
                    ]
                )
            ),
            RequestMethodInterface::METHOD_GET
        );

        $metricCollectionResponse = new SDK\Metrics\Transport\DTO\MetricCollectionResponse(
            SDK\Metrics\DTO\Fabric::initMetricCollectionFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.Metrics.transport.admin.getMetricCollection.finish',
            [
                'metadata' => SDK\Transport\Formatters\Metadata::toArray($metricCollectionResponse->getMeta()),
            ]
        );

        return $metricCollectionResponse;
    }

    /**
     * @param Metrics\DTO\MetricCode $metricCode
     * @param \DateTime              $dateFrom
     * @param \DateTime              $dateTo
     *
     * @return Metrics\Transport\DTO\MetricReportResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getReportByMetricCode(
        Metrics\DTO\MetricCode $metricCode,
        \DateTime $dateFrom,
        \DateTime $dateTo
    ): Metrics\Transport\DTO\MetricReportResponse {
        $this->log->debug(
            'b24io.loyalty.sdk.Metrics.transport.admin.getReportByMetricCode.start',
            [
                'metricCode' => $metricCode->getValue(),
                'dateFrom'   => $dateFrom->format(\DATE_ATOM),
                'dateTo'     => $dateTo->format(\DATE_ATOM),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                'admin/metrics/%s/?%s',
                $metricCode->getValue(),
                http_build_query(
                    [
                        self::CLIENT_API_KEY => $this->apiClient->getAuthToken()->getClientApiKey(),
                        self::DATE_FROM      => $dateFrom->format(\DATE_RFC3339),
                        self::DATE_TO        => $dateTo->format(\DATE_RFC3339),
                    ]
                )
            ),
            RequestMethodInterface::METHOD_GET
        );

        $metricReportResponse = new SDK\Metrics\Transport\DTO\MetricReportResponse(
            SDK\Metrics\DTO\Fabric::initReportFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.Metrics.transport.admin.getReportByMetricCode.finish',
            [
                'metadata' => SDK\Transport\Formatters\Metadata::toArray($metricReportResponse->getMeta()),
            ]
        );

        return $metricReportResponse;
    }
}