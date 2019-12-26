<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Operations;

use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Contact;
use B24io\Loyalty\SDK\Exceptions\ObjectInitializationException;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Bitrix24\Contacts;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class Fabric
{
    /**
     * @param array  $arOperation
     * @param string $countryRegionCode An ISO 3166-1 two letter country code.
     *
     * @return AddContact
     * @throws ObjectInitializationException
     */
    public static function initAddNewContactOperationFromArray(array $arOperation): AddContact
    {
        try {
            $operation = new AddContact();
            $operation
                ->setCreated(new \DateTime($arOperation['timestamp']))
                ->setOperationCode($arOperation['operation_code'])
                ->setContact(Contacts\DTO\Fabric::initContactFromArray($arOperation['contact']))
                ->setReason(Reason::initReasonFromArray($arOperation['reason']));

            return $operation;
        } catch (\Throwable $exception) {
            throw new ObjectInitializationException(
                sprintf('AddNewContactOperation initialization from array error «%s»', $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param array $arOperation
     *
     * @return AddContactWithCardNumber
     * @throws ObjectInitializationException
     */
    public static function initAddNewContactWithCardNumberOperationFromArray(array $arOperation): AddContactWithCardNumber
    {
        try {
            $operation = new AddContactWithCardNumber();
            $operation
                ->setCreated(new \DateTime($arOperation['timestamp']))
                ->setOperationCode($arOperation['operation_code'])
                ->setCardNumber((int)$arOperation['card_number'])
                ->setContact(Contacts\DTO\Fabric::initContactFromArray($arOperation['contact']))
                ->setReason(Reason::initReasonFromArray($arOperation['reason']));

            return $operation;
        } catch (\Throwable $exception) {
            throw new ObjectInitializationException(
                sprintf('AddNewContactWithCardNumberOperation initialization from array error «%s»', $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param Contact $contact
     * @param Reason  $reason
     *
     * @return AddContact
     * @throws ObjectInitializationException
     */
    public static function createAddNewContactOperation(Contact $contact, Reason $reason): AddContact
    {
        try {
            $operation = new AddContact();
            $operation
                ->setCreated(new \DateTime())
                ->setContact($contact)
                ->setOperationCode('add-contact')
                ->setReason($reason);

            return $operation;
        } catch (\Throwable $exception) {
            throw new ObjectInitializationException(
                sprintf('AddNewContactOperation initialization error «%s»', $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }

    /**
     * @param Contact $contact
     * @param Reason  $reason
     * @param int     $cardNumber
     *
     * @return AddContactWithCardNumber
     * @throws ObjectInitializationException
     */
    public static function createAddNewContactWithCardNumberOperation(
        Contact $contact,
        Reason $reason,
        int $cardNumber
    ): AddContactWithCardNumber {
        try {
            $operation = new AddContactWithCardNumber();
            $operation
                ->setCreated(new \DateTime())
                ->setContact($contact)
                ->setCardNumber($cardNumber)
                ->setOperationCode('add-contact-with-card-number')
                ->setReason($reason);

            return $operation;
        } catch (\Throwable $exception) {
            throw new ObjectInitializationException(
                sprintf('AddNewContactWithCardNumberOperation initialization error «%s»', $exception->getMessage()),
                $exception->getCode(),
                $exception
            );
        }
    }
}