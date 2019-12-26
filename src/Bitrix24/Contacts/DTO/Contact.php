<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

use B24io\Loyalty\SDK\Users\DTO\UserId;
use B24io\Loyalty\SDK\Users\DTO\Email;
use libphonenumber\PhoneNumber;

/**
 * Class Contact
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class Contact
{
    /**
     * @var UserId|null
     */
    private $contactId;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string|null
     */
    private $secondName;
    /**
     * @var string|null
     */
    private $lastName;
    /**
     * @var \DateTime|null
     */
    private $birthday;
    /**
     * @var string|null
     */
    private $comments;
    /**
     * @var \DateTime
     */
    private $created;
    /**
     * @var \DateTime
     */
    private $modified;
    /**
     * @var PhoneNumber|null
     */
    private $mobilePhone;
    /**
     * @var Email|null
     */
    private $email;
    /**
     * @var Address|null
     */
    private $address;
    /**
     * @var string|null
     */
    private $originId;
    /**
     * @var string|null
     */
    private $originatorId;
    /**
     * @var UTM|null
     */
    private $utm;
    /**
     * @var string|null
     */
    private $sourceDescription;

    /**
     * @return string|null
     */
    public function getSourceDescription(): ?string
    {
        return $this->sourceDescription;
    }

    /**
     * @param string|null $sourceDescription
     *
     * @return Contact
     */
    public function setSourceDescription(?string $sourceDescription): Contact
    {
        $this->sourceDescription = $sourceDescription;

        return $this;
    }

    /**
     * @return UTM|null
     */
    public function getUtm(): ?UTM
    {
        return $this->utm;
    }

    /**
     * @param UTM|null $utm
     *
     * @return Contact
     */
    public function setUtm(?UTM $utm): Contact
    {
        $this->utm = $utm;

        return $this;
    }

    /**
     * @return UserId|null
     */
    public function getContactId(): ?UserId
    {
        return $this->contactId;
    }

    /**
     * @param UserId|null $contactId
     *
     * @return Contact
     */
    public function setContactId(?UserId $contactId): Contact
    {
        $this->contactId = $contactId;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Contact
     */
    public function setName(string $name): Contact
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    /**
     * @param string|null $secondName
     *
     * @return Contact
     */
    public function setSecondName(?string $secondName): Contact
    {
        $this->secondName = $secondName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string|null $lastName
     *
     * @return Contact
     */
    public function setLastName(?string $lastName): Contact
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime|null $birthday
     *
     * @return Contact
     */
    public function setBirthday(?\DateTime $birthday): Contact
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @param string|null $comments
     *
     * @return Contact
     */
    public function setComments(?string $comments): Contact
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     *
     * @return Contact
     */
    public function setCreated(\DateTime $created): Contact
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getModified(): ?\DateTime
    {
        return $this->modified;
    }

    /**
     * @param \DateTime|null $modified
     *
     * @return Contact
     */
    public function setModified(?\DateTime $modified): Contact
    {
        $this->modified = $modified;

        return $this;
    }

    /**
     * @return PhoneNumber|null
     */
    public function getMobilePhone(): ?PhoneNumber
    {
        return $this->mobilePhone;
    }

    /**
     * @param PhoneNumber $mobilePhone
     *
     * @return Contact
     */
    public function setMobilePhone(PhoneNumber $mobilePhone): Contact
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * @return Email|null
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @param Email|null $email
     *
     * @return Contact
     */
    public function setEmail(?Email $email): Contact
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     *
     * @return Contact
     */
    public function setAddress(Address $address): Contact
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginId(): ?string
    {
        return $this->originId;
    }

    /**
     * @param string|null $originId
     *
     * @return Contact
     */
    public function setOriginId(?string $originId): Contact
    {
        $this->originId = $originId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getOriginatorId(): ?string
    {
        return $this->originatorId;
    }

    /**
     * @param string|null $originatorId
     *
     * @return Contact
     */
    public function setOriginatorId(?string $originatorId): Contact
    {
        $this->originatorId = $originatorId;

        return $this;
    }
}