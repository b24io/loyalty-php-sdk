<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters;

use B24io\Loyalty\SDK\Users\DTO\UserId;
use B24io\Loyalty\SDK\Users\DTO\Email;
use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Address;
use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\UTM;
use libphonenumber\PhoneNumber;

/**
 * Class Contact
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class Contact
{
    public static function toArray(\B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Contact $contact): array
    {
        return [
            'id' => $contact->getUserId() !== null ? $contact->getUserId()->getId() : null,
            'name' => $contact->getName(),
            'second_name' => $contact->getSecondName(),
            'last_name' => $contact->getLastName(),
            'birthday' => $contact->getBirthday() !== null ? $contact->getBirthday()->format(\DATE_ATOM) : null,
            'comments' => $contact->getComments(),
            'created' => $contact->getCreated()->format(\DATE_ATOM),
            'modified' => $contact->getModified()->format(\DATE_ATOM),
            'mobile_phone' => $contact->getMobilePhone()->getNationalNumber(),
            'email' => (string)$contact->getEmail()

//    /**
//     * @var Address
//     */
//    private $address;
//    /**
//     * @var string|null
//     */
//    private $originId;
//    /**
//     * @var string|null
//     */
//    private $originatorId;
//    /**
//     * @var UTM
//     */
//    private $utm;

        ];
    }
}