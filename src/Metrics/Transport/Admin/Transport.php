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
                'admin/metrics/?loyalty_client_api_key=%s',
                $this->apiClient->getAuthToken()->getClientApiKey()
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
}