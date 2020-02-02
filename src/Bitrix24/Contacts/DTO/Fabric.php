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
            return new Contact(
                new \DateTime($arContact['created']),
                new \DateTime($arContact['modified']),
                $arContact['name'],
                $arContact['second_name'],
                $arContact['last_name'],
                $arContact['mobile_phone'] !== null ? self::initMobilePhoneFromArray($arContact['mobile_phone']) : null,
                $arContact['email'] !== null ? new Users\DTO\Email($arContact['email']) : null,
                $arContact['id'] !== null ? new Users\DTO\UserId((int)$arContact['id']) : null,
                $arContact['birthday'] !== null ? new \DateTime($arContact['birthday']) : null,
                $arContact['comments'],
                $arContact['address'] !== null ? Address::initFromArray($arContact['address']) : null,
                $arContact['origin_id'],
                $arContact['originator_id'],
                $arContact['source_description'],
                $arContact['utm'] !== null ? UTM::initFromArray($arContact['utm']) : null
            );
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
        $result->rewind();

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
        $cardDto = null;
        if ($filtrationResult['card'] !== null) {
            $cardDto = Cards\DTO\Fabric::initFromArray($filtrationResult['card']);
        }

        return new FiltrationResult(self::initContactFromArray($filtrationResult['contact']), $cardDto);
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