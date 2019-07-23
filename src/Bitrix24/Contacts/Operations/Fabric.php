<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Operations;

use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Contact;
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
     * @param array $arOperation
     *
     * @return AddContact
     * @throws \libphonenumber\NumberParseException
     * @throws \Exception
     */
    public static function initAddNewContactOperationFromArray(array $arOperation): AddContact
    {
        $blockCardOperation = new AddContact();
        $blockCardOperation
            ->setCreated(new \DateTime($arOperation['timestamp']))
            ->setOperationCode($arOperation['add-contact'])
            ->setContact(Contacts\DTO\Fabric::initContactFromArray($arOperation['contact']))
            ->setReason(Reason::initReasonFromArray($arOperation['reason']));

        return $blockCardOperation;
    }

    /**
     * @param Contact $contact
     * @param Reason  $reason
     *
     * @return AddContact
     * @throws \Exception
     */
    public static function createAddNewContactOperation(Contact $contact, Reason $reason): AddContact
    {
        $operation = new AddContact();
        $operation
            ->setCreated(new \DateTime())
            ->setContact($contact)
            ->setOperationCode('add-contact')
            ->setReason($reason);

        return $operation;
    }
}