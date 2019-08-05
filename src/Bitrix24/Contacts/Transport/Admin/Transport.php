<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\DTO\ContactResponse;

use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Transactions\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @param SDK\Bitrix24\Contacts\DTO\Contact $newContact
     * @param SDK\Transport\DTO\Reason          $reason
     * @param string                            $countryRegionCode An ISO 3166-1 two letter country code.
     *
     * @return ContactResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\ObjectInitializationException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function add(SDK\Bitrix24\Contacts\DTO\Contact $newContact, SDK\Transport\DTO\Reason $reason, string $countryRegionCode): ContactResponse
    {
        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.add.start', [
            'contact' => SDK\Bitrix24\Contacts\Formatters\Contact::toArray($newContact),
            'reason' => SDK\Transport\Formatters\Reason::toArray($reason),
            'defaultCountryRegionCode' => $countryRegionCode,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/bitrix24-contacts/add',
            RequestMethodInterface::METHOD_POST,
            SDK\Bitrix24\Contacts\Formatters\AddContact::toArray(
                SDK\Bitrix24\Contacts\Operations\Fabric::createAddNewContactOperation($newContact, $reason)));

        $response = new ContactResponse(
            $this->initMetadata($requestResult['meta']),
            SDK\Bitrix24\Contacts\DTO\Fabric::initContactFromArray($requestResult['result']['contact'], $countryRegionCode),
            null);

        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.add.finish', [
            'contact' => SDK\Bitrix24\Contacts\Formatters\Contact::toArray($response->getContact()),
            'card' => null,
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($response->getMeta()),
        ]);

        return $response;
    }

    /**
     * @param SDK\Bitrix24\Contacts\DTO\Contact $newContact
     * @param int                               $cardNumber
     * @param SDK\Transport\DTO\Reason          $reason
     * @param string                            $countryRegionCode
     *
     * @return ContactResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\ObjectInitializationException
     * @throws SDK\Exceptions\TransportFormatException
     * @throws SDK\Exceptions\UnknownException
     */
    public function addWithCardNumber(SDK\Bitrix24\Contacts\DTO\Contact $newContact, int $cardNumber, SDK\Transport\DTO\Reason $reason, string $countryRegionCode): ContactResponse
    {
        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.addWithCardNumber.start', [
            'contact' => SDK\Bitrix24\Contacts\Formatters\Contact::toArray($newContact),
            'cardNumber' => $cardNumber,
            'reason' => SDK\Transport\Formatters\Reason::toArray($reason),
            'defaultCountryRegionCode' => $countryRegionCode,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/bitrix24-contacts/add-with-card-number',
            RequestMethodInterface::METHOD_POST,
            SDK\Bitrix24\Contacts\Formatters\AddContactWithCardNumber::toArray(
                SDK\Bitrix24\Contacts\Operations\Fabric::createAddNewContactWithCardNumberOperation($newContact, $reason, $cardNumber)));

        $response = new ContactResponse(
            $this->initMetadata($requestResult['meta']),
            SDK\Bitrix24\Contacts\DTO\Fabric::initContactFromArray($requestResult['result']['contact'], $countryRegionCode),
            SDK\Cards\DTO\Fabric::initFromArray($requestResult['result']['card']));

        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.addWithCardNumber.finish', [
            'contact' => $response->getContact() !== null ? SDK\Bitrix24\Contacts\Formatters\Contact::toArray($response->getContact()) : null,
            'card' => $response->getCard() !== null ? SDK\Cards\Formatters\Card::toArray($response->getCard()) : null,
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($response->getMeta()),
        ]);

        return $response;
    }
}