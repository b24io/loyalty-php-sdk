<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\User;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\DTO\ContactResponse;

use Fig\Http\Message\RequestMethodInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\User
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @param UuidInterface $cardUuid
     *
     * @return ContactResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\ObjectInitializationException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getByCardUuid(UuidInterface $cardUuid): ContactResponse
    {
        $this->log->debug(
            'b24io.loyalty.sdk.bitrix24.contacts.transport.user.getByCardUuid.start',
            [
                'cardUuid' => $cardUuid->toString(),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('user/bitrix24-contacts/get-by-card-uuid/%s/', $cardUuid->toString()),
            RequestMethodInterface::METHOD_GET
        );

        $response = new ContactResponse(
            $this->initMetadata($requestResult['meta']),
            SDK\Bitrix24\Contacts\DTO\Fabric::initContactFromArray($requestResult['result']['contact']),
            SDK\Cards\DTO\Fabric::initFromArray($requestResult['result']['card'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.Bitrix24.Contacts.transport.user.getByCardUuid.finish',
            [
                'contact'  => $response->getContact() !== null ? SDK\Bitrix24\Contacts\Formatters\Contact::toArray(
                    $response->getContact()
                ) : null,
                'card'     => $response->getCard() !== null ? SDK\Cards\Formatters\Card::toArray($response->getCard()) : null,
                'metadata' => SDK\Transport\Formatters\Metadata::toArray($response->getMeta()),
            ]
        );

        return $response;
    }
}