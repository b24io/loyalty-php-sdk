<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class AddContactWithCardNumber
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters
 */
class AddContactWithCardNumber
{
    /**
     * @param SDK\Bitrix24\Contacts\Operations\AddContactWithCardNumber $addContactWithCardNumber
     *
     * @return array
     */
    public static function toArray(SDK\Bitrix24\Contacts\Operations\AddContactWithCardNumber $addContactWithCardNumber): array
    {
        return [
            'timestamp' => $addContactWithCardNumber->getCreated()->format(\DATE_ATOM),
            'operation_code' => $addContactWithCardNumber->getOperationCode(),
            'card_number' => $addContactWithCardNumber->getCardNumber(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($addContactWithCardNumber->getReason()),
            'contact' => SDK\Bitrix24\Contacts\Formatters\Contact::toArray($addContactWithCardNumber->getContact()),
        ];
    }
}