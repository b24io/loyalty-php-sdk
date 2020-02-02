<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

/**
 * Class Address
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class Address
{
    /**
     * @var string|null
     */
    private $street;
    /**
     * @var string|null
     */
    private $apartment;
    /**
     * @var string|null
     */
    private $city;
    /**
     * @var string|null
     */
    private $postalCode;
    /**
     * @var string|null
     */
    private $region;
    /**
     * @var string|null
     */
    private $province;
    /**
     * @var string|null
     */
    private $country;
    /**
     * @var string|null
     */
    private $countryCode;

    /**
     * Address constructor.
     *
     * @param string|null $street
     * @param string|null $apartment
     * @param string|null $city
     * @param string|null $postalCode
     * @param string|null $region
     * @param string|null $province
     * @param string|null $country
     * @param string|null $countryCode
     */
    public function __construct(
        ?string $street,
        ?string $apartment,
        ?string $city,
        ?string $postalCode,
        ?string $region,
        ?string $province,
        ?string $country,
        ?string $countryCode
    ) {
        $this->street = $street;
        $this->apartment = $apartment;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->region = $region;
        $this->province = $province;
        $this->country = $country;
        $this->countryCode = $countryCode;
    }


    /**
     * @param array $arAddress
     *
     * @return Address
     */
    public static function initFromArray(array $arAddress): self
    {
        return new self(
            $arAddress['street'],
            $arAddress['apartment'],
            $arAddress['city'],
            $arAddress['postal_code'],
            $arAddress['region'],
            $arAddress['province'],
            $arAddress['country'],
            $arAddress['country_code']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'country'      => $this->getCountry(),
            'country_code' => $this->getCountryCode(),
            'region'       => $this->getRegion(),
            'province'     => $this->getProvince(),
            'city'         => $this->getCity(),
            'postal_code'  => $this->getPostalCode(),
            'apartment'    => $this->getApartment(),
            'street'       => $this->getStreet(),
        ];
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @return string|null
     */
    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @return string|null
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }
}
