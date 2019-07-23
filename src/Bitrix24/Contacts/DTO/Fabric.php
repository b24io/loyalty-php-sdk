<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Users;
use libphonenumber\PhoneNumber;
use Money\Currency;
use Money\Money;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class Fabric
{
    /**
     * @param array $arContact
     *
     * @return Contact
     * @throws \libphonenumber\NumberParseException
     * @throws \Exception
     */
    public static function initContactFromArray(array $arContact): Contact
    {
        $newContact = new Contact();
        if ($arContact['id'] !== null) {
            $newContact->setUserId(new Users\DTO\UserId($arContact['id']));
        }

        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $newContact
            ->setName($arContact['name'])
            ->setSecondName($arContact['second_name'])
            ->setLastName($arContact['last_name'])
            ->setComments($arContact['comments'])
            ->setCreated(new \DateTime($arContact['created']))
            ->setModified(new \DateTime($arContact['modified']))
            ->setMobilePhone($phoneUtil->parse($arContact['mobile_phone']))
            ->setOriginId($arContact['origin_id'])
            ->setOriginatorId($arContact['originator_id']);
        if ($arContact['birthday'] !== null) {
            $newContact->setBirthday(new \DateTime($arContact['birthday']));
        }
        if ($arContact['email'] !== null) {
            $newContact->setEmail(new Users\DTO\Email($arContact['email']));
        }
        if ($arContact['utm'] !== null) {
            $newContact->setUtm(UTM::initFromArray($arContact['utm']));
        }
        if ($arContact['address'] !== null) {
            $newContact->setAddress(Address::initFromArray($arContact['address']));
        }

        return $newContact;
    }
}