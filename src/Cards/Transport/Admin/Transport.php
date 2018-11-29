<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;

use GuzzleHttp\Client;
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
     * @return Cards\Transport\DTO\CardResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getCardByNumber(int $cardNumber): SDK\Cards\Transport\DTO\CardResponse
    {
        $this->log->debug('b24io.loyalty.sdk.cards.transport.admin.getCardByNumber.start', [
            'cardNumber' => $cardNumber,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            sprintf('admin/card/%s', $cardNumber),
            RequestMethodInterface::METHOD_GET,
            []
        );

        $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
            Cards\DTO\Fabric::initFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug('b24io.loyalty.sdk.cards.transport.admin.getCardByNumber.finish', [
            'cardNumber' => $cardNumber,
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
        ]);

        return $cardResponse;
    }

    /**
     * @param int                      $cardNumber
     * @param SDK\Users\DTO\UserId     $userId
     * @param SDK\Transport\DTO\Reason $reason
     *
     * @return Cards\Transport\DTO\CardResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function addNewCardWithCardNumber(int $cardNumber, SDK\Users\DTO\UserId $userId, SDK\Transport\DTO\Reason $reason): Cards\Transport\DTO\CardResponse
    {
        $this->log->debug('b24io.loyalty.sdk.cards.transport.admin.addNewCardWithCardNumber.start', [
            'cardNumber' => $cardNumber,
            'userId' => $userId->getId(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($reason),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/card/add',
            RequestMethodInterface::METHOD_POST,
            SDK\Cards\Formatters\AddCard::toArray(SDK\Cards\Operations\Fabric::createAddCardOperation($cardNumber, $reason, $userId))
        );

        $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
            Cards\DTO\Fabric::initFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug('b24io.loyalty.sdk.cards.transport.admin.addNewCardWithCardNumber.finish', [
            'cardNumber' => $cardResponse->getCard()->getNumber(),
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
        ]);

        return $cardResponse;
    }
}