<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;

use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Transport\Admin
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
            'b24io.loyalty.sdk.cards.transport.admin.getCardByUuid.start',
            [
                'cardUuid' => $cardUuid->toString(),
            ]
        );

        try {
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('admin/card/get-by-uuid/%s', $cardUuid->toString()),
                RequestMethodInterface::METHOD_GET,
                []
            );

            $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
                Cards\DTO\Fabric::initFromArray($requestResult['result']),
                $this->initMetadata($requestResult['meta'])
            );

            $this->log->debug(
                'b24io.loyalty.sdk.cards.transport.admin.getCardByUuid.finish',
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
        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.getCardByNumber.start',
            [
                'cardNumber' => $cardNumber,
            ]
        );

        try {
            $requestResult = $this->apiClient->executeApiRequest(
                sprintf('admin/card/%s', $cardNumber),
                RequestMethodInterface::METHOD_GET,
                []
            );

            $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
                Cards\DTO\Fabric::initFromArray($requestResult['result']),
                $this->initMetadata($requestResult['meta'])
            );

            $this->log->debug(
                'b24io.loyalty.sdk.cards.transport.admin.getCardByNumber.finish',
                [
                    'cardNumber' => $cardNumber,
                    'metadata'   => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
                ]
            );

            return $cardResponse;
        } catch (SDK\Exceptions\ApiClientException $exception) {
            if (StatusCodeInterface::STATUS_NOT_FOUND === $exception->getApiProblem()->getStatus()) {
                throw new Cards\Exceptions\CardNotFound(
                    $exception->getApiProblem(),
                    sprintf('card with number %s not found', $cardNumber),
                    $exception->getCode(), $exception
                );
            }
            throw $exception;
        }
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
    public function addNewCardWithNumber(
        int $cardNumber,
        SDK\Users\DTO\UserId $userId,
        SDK\Transport\DTO\Reason $reason
    ): Cards\Transport\DTO\CardResponse {
        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.addNewCardWithCardNumber.start',
            [
                'cardNumber' => $cardNumber,
                'userId'     => $userId->getId(),
                'reason'     => SDK\Transport\Formatters\Reason::toArray($reason),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/card/add',
            RequestMethodInterface::METHOD_POST,
            SDK\Cards\Formatters\AddCard::toArray(SDK\Cards\Operations\Fabric::createAddCardOperation($cardNumber, $reason, $userId))
        );

        $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
            Cards\DTO\Fabric::initFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.addNewCardWithCardNumber.finish',
            [
                'cardNumber' => $cardResponse->getCard()->getNumber(),
                'metadata'   => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
            ]
        );

        return $cardResponse;
    }

    /**
     * @param int                      $cardNumber
     * @param SDK\Transport\DTO\Reason $reason
     *
     * @return Cards\Transport\DTO\CardResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function blockCardWithNumber(int $cardNumber, SDK\Transport\DTO\Reason $reason): Cards\Transport\DTO\CardResponse
    {
        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.blockCardWithCardNumber.start',
            [
                'cardNumber' => $cardNumber,
                'reason'     => SDK\Transport\Formatters\Reason::toArray($reason),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/card/block',
            RequestMethodInterface::METHOD_POST,
            SDK\Cards\Formatters\BlockCard::toArray(SDK\Cards\Operations\Fabric::createBlockCardOperation($cardNumber, $reason))
        );

        $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
            Cards\DTO\Fabric::initFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.blockCardWithCardNumber.finish',
            [
                'cardNumber' => $cardResponse->getCard()->getNumber(),
                'metadata'   => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
            ]
        );

        return $cardResponse;
    }

    /**
     * @param int                      $cardNumber
     * @param SDK\Transport\DTO\Reason $reason
     *
     * @return Cards\Transport\DTO\CardResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function unblockCardWithNumber(int $cardNumber, SDK\Transport\DTO\Reason $reason): Cards\Transport\DTO\CardResponse
    {
        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.unblockCardWithCardNumber.start',
            [
                'cardNumber' => $cardNumber,
                'reason'     => SDK\Transport\Formatters\Reason::toArray($reason),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/card/unblock',
            RequestMethodInterface::METHOD_POST,
            SDK\Cards\Formatters\UnblockCard::toArray(SDK\Cards\Operations\Fabric::createUnblockCardOperation($cardNumber, $reason))
        );

        $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
            Cards\DTO\Fabric::initFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.unblockCardWithCardNumber.finish',
            [
                'cardNumber' => $cardResponse->getCard()->getNumber(),
                'metadata'   => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
            ]
        );

        return $cardResponse;
    }

    /**
     * @param int                      $cardNumber
     * @param SDK\Transport\DTO\Reason $reason
     *
     * @return Cards\Transport\DTO\CardResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function deleteCardWithNumber(int $cardNumber, SDK\Transport\DTO\Reason $reason): Cards\Transport\DTO\CardResponse
    {
        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.deleteCardWithNumber.start',
            [
                'cardNumber' => $cardNumber,
                'reason'     => SDK\Transport\Formatters\Reason::toArray($reason),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/card/delete',
            RequestMethodInterface::METHOD_POST,
            SDK\Cards\Formatters\DeleteCard::toArray(SDK\Cards\Operations\Fabric::createDeleteCardOperation($cardNumber, $reason))
        );

        $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
            Cards\DTO\Fabric::initFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.deleteCardWithNumber.finish',
            [
                'cardNumber' => $cardResponse->getCard()->getNumber(),
                'metadata'   => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
            ]
        );

        return $cardResponse;
    }

    /**
     * @param int                      $cardNumber
     * @param Cards\DTO\Percentage     $percentage
     * @param SDK\Transport\DTO\Reason $reason
     *
     * @return Cards\Transport\DTO\CardResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function setPercentageForCardWithNumber(
        int $cardNumber,
        Cards\DTO\Percentage $percentage,
        SDK\Transport\DTO\Reason $reason
    ): Cards\Transport\DTO\CardResponse {
        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.setPercentageForCardWithNumber.start',
            [
                'cardNumber' => $cardNumber,
                'percentage' => $percentage,
                'reason'     => SDK\Transport\Formatters\Reason::toArray($reason),
            ]
        );

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/card/percentage',
            RequestMethodInterface::METHOD_POST,
            SDK\Cards\Formatters\ChangePercentage::toArray(
                SDK\Cards\Operations\Fabric::createChangePercentageOperation($cardNumber, $reason, $percentage)
            )
        );

        $cardResponse = new SDK\Cards\Transport\DTO\CardResponse(
            Cards\DTO\Fabric::initFromArray($requestResult['result']),
            $this->initMetadata($requestResult['meta'])
        );

        $this->log->debug(
            'b24io.loyalty.sdk.cards.transport.admin.setPercentageForCardWithNumber.finish',
            [
                'cardNumber' => $cardResponse->getCard()->getNumber(),
                'metadata'   => SDK\Transport\Formatters\Metadata::toArray($cardResponse->getMeta()),
            ]
        );

        return $cardResponse;
    }
}