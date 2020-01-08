<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Transport\User;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;

use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Turnover\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     *
     * @return SDK\OperationsJournal\Transport\DTO\OperationsJournalResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getOperationsByPeriod(
        \DateTime $dateFrom,
        \DateTime $dateTo
    ): SDK\OperationsJournal\Transport\DTO\OperationsJournalResponse {
        $this->log->debug(
            'b24io.loyalty.sdk.OperationsJournal.transport.user.getOperationsByPeriod.start',
            [
                'dateFrom' => $dateFrom->format(\DATE_ATOM),
                'dateTo'   => $dateTo->format(\DATE_ATOM),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                'user/operations-journal/get-by-card-uuid/%s/?dateFrom=%s&dateTo=%s',
                $this->apiClient->getAuthToken()->getAuthApiKey()->toString(),
                urlencode($dateFrom->format(\DATE_RFC3339)),
                urlencode($dateTo->format(\DATE_RFC3339))
            ),
            RequestMethodInterface::METHOD_GET,
            []
        );

        $operationsJournal = new SDK\OperationsJournal\Transport\DTO\OperationsJournalResponse(
            SDK\OperationsJournal\DTO\Fabric::initOperationsJournalFromArray($requestResult['result'], $this->log),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.turnover.transport.user.getOperationsByPeriod.finish',
            [
                'metadata' => SDK\Transport\Formatters\Metadata::toArray($operationsJournal->getMeta()),
            ]
        );

        return $operationsJournal;
    }
}