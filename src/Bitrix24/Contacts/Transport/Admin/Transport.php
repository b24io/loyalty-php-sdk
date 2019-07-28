<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Transactions\Transport\DTO\ContactResponse;

use Fig\Http\Message\RequestMethodInterface;
use libphonenumber\PhoneNumber;
use Money\Money;

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
     *
     * @return ContactResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     * @throws \libphonenumber\NumberParseException
     * @throws \Exception
     */
    public function add(SDK\Bitrix24\Contacts\DTO\Contact $newContact, SDK\Transport\DTO\Reason $reason): ContactResponse
    {
        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.add.start', [
            'contact' => SDK\Bitrix24\Contacts\Formatters\Contact::toArray($newContact),
            'reason' => SDK\Transport\Formatters\Reason::toArray($reason),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/bitrix24/contacts/add',
            RequestMethodInterface::METHOD_POST,
            SDK\Bitrix24\Contacts\Formatters\AddContact::toArray(
                SDK\Bitrix24\Contacts\Operations\Fabric::createAddNewContactOperation($newContact, $reason))
        );

        $response = new ContactResponse($this->initMetadata($requestResult['meta']),
            SDK\Bitrix24\Contacts\DTO\Fabric::initContactFromArray($requestResult['result']['contact']),
            SDK\Cards\DTO\Fabric::initFromArray($requestResult['result']['card']));

        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.add.finish', [
            'contactId' => $response->getContact()->getUserId()->getId(),
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($response->getMeta()),
        ]);

        return $response;
    }

    /**
     * @param SDK\Bitrix24\Contacts\DTO\Contact $newContact
     * @param string                            $cardNumber
     * @param SDK\Transport\DTO\Reason          $reason
     *
     * @return ContactResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\BaseLoyaltyException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     * @throws \libphonenumber\NumberParseException
     * @throws \Exception
     */
    public function addWithCardNumber(SDK\Bitrix24\Contacts\DTO\Contact $newContact, string $cardNumber, SDK\Transport\DTO\Reason $reason): ContactResponse
    {
        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.add.start', [
            'contact' => SDK\Bitrix24\Contacts\Formatters\Contact::toArray($newContact),
            'cardNumber' => $cardNumber,
            'reason' => SDK\Transport\Formatters\Reason::toArray($reason),
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/bitrix24-contacts/add',
            RequestMethodInterface::METHOD_POST,
            SDK\Bitrix24\Contacts\Formatters\AddContact::toArray(
                SDK\Bitrix24\Contacts\Operations\Fabric::createAddNewContactWithCardNumberOperation($newContact, $cardNumber, $reason))
        );

        $response = new ContactResponse($this->initMetadata($requestResult['meta']),
            SDK\Bitrix24\Contacts\DTO\Fabric::initContactFromArray($requestResult['result']['contact']),
            SDK\Cards\DTO\Fabric::initFromArray($requestResult['result']['card']));

        $this->log->debug('b24io.loyalty.sdk.Bitrix24.Contacts.transport.admin.add.finish', [
            'contactId' => $response->getContact()->getUserId()->getId(),
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($response->getMeta()),
        ]);

        return $response;
    }

    /**
     * @param SDK\Users\DTO\UserId $b24ContactId
     *
     * @return ContactResponse
     */
    public function getById(SDK\Users\DTO\UserId $b24ContactId): ContactResponse
    {
        return new ContactResponse(new SDK\Transport\DTO\Metadata(), new SDK\Bitrix24\Contacts\DTO\Contact());
    }

    /**
     * @param string $cardNumber
     *
     * @return ContactResponse
     */
    public function getByCardNumber(string $cardNumber): ContactResponse
    {
        return new ContactResponse(new SDK\Transport\DTO\Metadata(), new SDK\Bitrix24\Contacts\DTO\Contact());
    }

    /**
     * @param PhoneNumber $phoneNumber
     *
     * @return ContactResponse
     */
    public function findByPhone(PhoneNumber $phoneNumber): ContactResponse
    {
        return new ContactResponse(new SDK\Transport\DTO\Metadata(), new SDK\Bitrix24\Contacts\DTO\Contact());
    }
}