<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Exceptions\ObjectInitializationException;
use B24io\Loyalty\SDK\Users;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class Fabric
{
    /**
     * @param array  $arContact
     * @param string $countryRegionCode An ISO 3166-1 two letter country code.
     *
     * @return Contact
     * @throws ObjectInitializationException
     */
    public static function initContactFromArray(array $arContact, string $countryRegionCode): Contact
    {
        try {
            $newContact = new Contact();
            if ($arContact['id'] !== null) {
                $newContact->setContactId(new Users\DTO\UserId((int)$arContact['id']));
            }

            $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
            $newContact
                ->setName($arContact['name'])
                ->setSecondName($arContact['second_name'])
                ->setLastName($arContact['last_name'])
                ->setComments($arContact['comments'])
                ->setCreated(new \DateTime($arContact['created']))
                ->setModified(new \DateTime($arContact['modified']))
                ->setMobilePhone($phoneUtil->parse($arContact['mobile_phone'], $countryRegionCode))
                ->setOriginId($arContact['origin_id'])
                ->setOriginatorId($arContact['originator_id'])
                ->setSourceDescription($arContact['source_description']);
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
        } catch (\Throwable $exception) {
            throw new ObjectInitializationException(
                sprintf('contact initialization error «%s»', $exception->getMessage()),
                $exception->getCode(),
                $exception);
        }
    }
}