<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters;

/**
 * Class Address
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters
 */
class Address
{
    /**
     * @param \B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Address $address
     *
     * @return array
     */
    public static function toArray(\B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Address $address): array
    {
        return [
            'country' => $address->getCountry(),
            'country_code' => $address->getCountryCode(),
            'region' => $address->getRegion(),
            'province' => $address->getProvince(),
            'city' => $address->getCity(),
            'postal_code' => $address->getPostalCode(),
            'apartment' => $address->getApartment(),
            'street' => $address->getStreet(),
        ];
    }
}