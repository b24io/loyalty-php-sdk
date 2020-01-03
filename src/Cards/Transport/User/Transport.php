<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Transport\User;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;

use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Transport\User
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @param UuidInterface $cardUuid
     *
     * @return Cards\Transport\DTO\CardResponse
     * @throws Cards\Exceptions\CardNotFound
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getCardByUuid(UuidInterface $cardUuid): SDK\Cards\Transport\DTO\CardResponse
    {
        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.user.getCardByUuid.start',
            [
                'cardUuid' => $cardUuid->toString(),
            ]
        );

        try {
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('user/card/get-by-uuid/%s/', $cardUuid->toString()),
                RequestMethodInterface::METHOD_GET,
                []
            );

            $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
                Cards\DTO\Fabric::initFromArray($requestResult['result']),
                $this->initMetadata($requestResult['meta'])
            );

            $this->log->debug(
                'b24io.loyalty.sdk.cards.transport.user.getCardByUuid.finish',
                [
                    'cardNumber' => $cardUuid->toString(),
                    'metadata'   => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
                ]
            );

            return $cardResponse;
        } catch (SDK\Exceptions\ApiClientException $exception) {
            if (StatusCodeInterface::STATUS_NOT_FOUND === $exception->getApiProblem()->getStatus()) {
                throw new Cards\Exceptions\CardNotFound(
                    $exception->getApiProblem(),
                    sprintf('card with uuid %s not found', $cardUuid->toString()),
                    $exception->getCode(), $exception
                );
            }
            throw $exception;
        }
    }
}