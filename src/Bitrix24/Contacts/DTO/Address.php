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
     * @param array $arAddress
     *
     * @return Address
     */
    public static function initFromArray(array $arAddress): self
    {
        $address = new self();

        $address
            ->setCountry($arAddress['country'])
            ->setCountryCode($arAddress['country_code'])
            ->setRegion($arAddress['region'])
            ->setProvince($arAddress['province'])
            ->setCity($arAddress['city'])
            ->setPostalCode($arAddress['postal_code'])
            ->setApartment($arAddress['apartment'])
            ->setStreet($arAddress['street']);

        return $address;
    }


    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'country' => $this->getCountry(),
            'country_code' => $this->getCountryCode(),
            'region' => $this->getRegion(),
            'province' => $this->getProvince(),
            'city' => $this->getCity(),
            'postal_code' => $this->getPostalCode(),
            'apartment' => $this->getApartment(),
            'street' => $this->getStreet(),
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
     * @param string|null $street
     *
     * @return Address
     */
    public function setStreet(?string $street): Address
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    /**
     * @param string|null $apartment
     *
     * @return Address
     */
    public function setApartment(?string $apartment): Address
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     *
     * @return Address
     */
    public function setCity(?string $city): Address
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    /**
     * @param string|null $postalCode
     *
     * @return Address
     */
    public function setPostalCode(?string $postalCode): Address
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRegion(): ?string
    {
        return $this->region;
    }

    /**
     * @param string|null $region
     *
     * @return Address
     */
    public function setRegion(?string $region): Address
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @param string|null $province
     *
     * @return Address
     */
    public function setProvince(?string $province): Address
    {
        $this->province = $province;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     *
     * @return Address
     */
    public function setCountry(?string $country): Address
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    /**
     * @param string|null $countryCode
     *
     * @return Address
     */
    public function setCountryCode(?string $countryCode): Address
    {
        $this->countryCode = $countryCode;

        return $this;
    }
}
