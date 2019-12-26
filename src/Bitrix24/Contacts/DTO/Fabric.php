<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Exceptions\ObjectInitializationException;
use B24io\Loyalty\SDK\Users;
use libphonenumber\PhoneNumber;

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
     * @throws ObjectInitializationException
     */
    public static function initContactFromArray(array $arContact): Contact
    {
        try {
            $newContact = new Contact();
            if ($arContact['id'] !== null) {
                $newContact->setContactId(new Users\DTO\UserId((int)$arContact['id']));
            }

            $newContact
                ->setName($arContact['name'])
                ->setSecondName($arContact['second_name'])
                ->setLastName($arContact['last_name'])
                ->setComments($arContact['comments'])
                ->setCreated(new \DateTime($arContact['created']))
                ->setModified(new \DateTime($arContact['modified']))
                ->setOriginId($arContact['origin_id'])
                ->setOriginatorId($arContact['originator_id'])
                ->setSourceDescription($arContact['source_description']);
            if ($arContact['mobile_phone'] !== null) {
                $newContact->setMobilePhone(self::initMobilePhoneFromArray($arContact['mobile_phone']));
            }
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
                $exception
            );
        }
    }

    /**
     * @param array $filtrationResultCollection
     *
     * @return FiltrationResultCollection
     * @throws ObjectInitializationException
     * @throws \B24io\Loyalty\SDK\Exceptions\BaseLoyaltyException
     */
    public static function initFiltrationResultCollectionFromArray(array $filtrationResultCollection): FiltrationResultCollection
    {
        $result = new FiltrationResultCollection();

        foreach ($filtrationResultCollection as $item) {
            $result->attach(self::initFiltrationResultFromArray($item));
        }

        return $result;
    }

    /**
     * @param array $filtrationResult
     *
     * @return FiltrationResult
     * @throws ObjectInitializationException
     * @throws \B24io\Loyalty\SDK\Exceptions\BaseLoyaltyException
     */
    public static function initFiltrationResultFromArray(array $filtrationResult): FiltrationResult
    {
        return new FiltrationResult(
            self::initContactFromArray($filtrationResult['contact']),
            Cards\DTO\Fabric::initFromArray($filtrationResult['card'])
        );
    }

    /**
     * @param array $mobilePhone
     *
     * @return PhoneNumber
     * @throws \libphonenumber\NumberParseException
     */
    public static function initMobilePhoneFromArray(array $mobilePhone): PhoneNumber
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        return $phoneUtil->parse(
            $mobilePhone['national_number'],
            $phoneUtil->getRegionCodeForCountryCode($mobilePhone['country_code'])
        );
    }
}