<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\SystemJournal;

use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\SystemJournal\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @param \DateTime                       $dateFrom
     * @param \DateTime                       $dateTo
     * @param SystemJournal\DTO\LogLevel|null $level
     *
     * @return SystemJournal\Transport\DTO\SystemJournalResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getSystemJournalByPeriod(
        \DateTime $dateFrom,
        \DateTime $dateTo,
        ?SystemJournal\DTO\LogLevel $level
    ): SystemJournal\Transport\DTO\SystemJournalResponse {
        $this->log->debug(
            'b24io.loyalty.sdk.SystemJournal.transport.admin.getSystemJournalByPeriod.start',
            [
                'dateFrom' => $dateFrom->format(\DATE_ATOM),
                'dateTo'   => $dateTo->format(\DATE_ATOM),
                'level'    => $level !== null ? $level->key() : '',
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf(
                'admin/system-journal/?%s',
                http_build_query(
                    [
                        self::DATE_FROM => $dateFrom->format(\DATE_RFC3339),
                        self::DATE_TO   => $dateTo->format(\DATE_RFC3339),
                        'level'         => $level !== null ? $level->key() : '',
                    ]
                )
            ),
            RequestMethodInterface::METHOD_GET,
            []
        );

        $operationsJournal = new SDK\SystemJournal\Transport\DTO\SystemJournalResponse(
            SDK\SystemJournal\DTO\Fabric::initSystemJournalFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.SystemJournal.transport.admin.getSystemJournalByPeriod.finish',
            [
                'metadata' => SDK\Transport\Formatters\Metadata::toArray($operationsJournal->getMeta()),
            ]
        );

        return $operationsJournal;
    }
}