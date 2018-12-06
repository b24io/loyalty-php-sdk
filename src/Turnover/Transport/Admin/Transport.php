<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;

use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @param int $cardNumber
     *
     * @return SDK\Turnover\Transport\DTO\TurnoverResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getTurnoverByCardNumber(int $cardNumber): SDK\Turnover\Transport\DTO\TurnoverResponse
    {
        $this->log->debug('b24io.loyalty.sdk.turnover.transport.admin.getTurnoverByCardNumber.start', [
            'cardNumber' => $cardNumber,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('admin/turnover/%s', $cardNumber),
            RequestMethodInterface::METHOD_GET,
            []
        );

        $turnoverResponse = new SDK\Turnover\Transport\DTO\TurnoverResponse(
            $this->initMetadata($requestResult['meta']),
            SDK\Turnover\DTO\Fabric::initFromArray($requestResult['result'])

        );

        $this->log->debug('b24io.loyalty.sdk.turnover.transport.admin.getTurnoverByCardNumber.finish', [
            'cardNumber' => $cardNumber,
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($turnoverResponse->getMeta()),
        ]);

        return $turnoverResponse;
    }
}