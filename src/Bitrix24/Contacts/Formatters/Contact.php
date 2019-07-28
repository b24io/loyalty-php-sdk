<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters;

use B24io\Loyalty\SDK\Bitrix24\Contacts;

/**
 * Class Contact
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class Contact
{
    /**
     * @param Contacts\DTO\Contact $contact
     *
     * @return array
     */
    public static function toArray(Contacts\DTO\Contact $contact): array
    {
        return [
            'id' => $contact->getContactId() !== null ? $contact->getContactId()->getId() : null,
            'name' => $contact->getName(),
            'second_name' => $contact->getSecondName(),
            'last_name' => $contact->getLastName(),
            'birthday' => $contact->getBirthday() !== null ? $contact->getBirthday()->format(\DATE_ATOM) : null,
            'comments' => $contact->getComments(),
            'created' => $contact->getCreated()->format(\DATE_ATOM),
            'modified' => $contact->getModified() !== null ? $contact->getModified()->format(\DATE_ATOM) : null,
            'mobile_phone' => $contact->getMobilePhone()->getNationalNumber(),
            'email' => (string)$contact->getEmail(),
            'address' => $contact->getAddress() !== null ? $contact->getAddress()->toArray() : null,
            'origin_id' => $contact->getOriginId(),
            'originator_id' => $contact->getOriginatorId(),
            'utm' => $contact->getUtm() !== null ? $contact->getUtm()->toArray() : null,
        ];
    }
}