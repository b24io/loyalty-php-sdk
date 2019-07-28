<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class AddContact
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters
 */
class AddContact
{
    /**
     * @param SDK\Bitrix24\Contacts\Operations\AddContact $addContact
     *
     * @return array
     */
    public static function toArray(SDK\Bitrix24\Contacts\Operations\AddContact $addContact): array
    {
        return [
            'timestamp' => $addContact->getCreated()->format(\DATE_ATOM),
            'operation_code' => $addContact->getOperationCode(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($addContact->getReason()),
            'contact' => SDK\Bitrix24\Contacts\Formatters\Contact::toArray($addContact->getContact()),
        ];
    }
}