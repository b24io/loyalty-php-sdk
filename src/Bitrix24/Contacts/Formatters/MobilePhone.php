<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters;

use libphonenumber\PhoneNumber;

/**
 * Class MobilePhone
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters
 */
class MobilePhone
{
    /**
     * @param PhoneNumber $number
     *
     * @return array
     */
    public static function toArray(PhoneNumber $number): array
    {
        return [
            'national_number' => $number->getNationalNumber(),
            'country_code'    => $number->getCountryCode(),
        ];
    }
}