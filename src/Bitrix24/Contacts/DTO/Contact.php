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
     * Contact constructor.
     *
     * @param \DateTime        $created
     * @param \DateTime        $modified
     * @param string           $name
     * @param string|null      $secondName
     * @param string|null      $lastName
     * @param PhoneNumber|null $mobilePhone
     * @param Email|null       $email
     * @param UserId|null      $contactId
     * @param \DateTime|null   $birthday
     * @param string|null      $comments
     * @param Address|null     $address
     * @param string|null      $originId
     * @param string|null      $originatorId
     * @param string|null      $sourceDescription
     * @param UTM|null         $utm
     */
    public function __construct(
        \DateTime $created,
        \DateTime $modified,
        string $name,
        ?string $secondName,
        ?string $lastName,
        ?PhoneNumber $mobilePhone,
        ?Email $email = null,
        ?UserId $contactId = null,
        ?\DateTime $birthday = null,
        ?string $comments = null,
        ?Address $address = null,
        ?string $originId = null,
        ?string $originatorId = null,
        ?string $sourceDescription = null,
        ?UTM $utm = null
    ) {
        $this->created = $created;
        $this->modified = $modified;
        $this->name = $name;
        $this->secondName = $secondName;
        $this->lastName = $lastName;
        $this->mobilePhone = $mobilePhone;
        $this->email = $email;
        $this->contactId = $contactId;
        $this->birthday = $birthday;
        $this->comments = $comments;
        $this->address = $address;
        $this->originId = $originId;
        $this->originatorId = $originatorId;
        $this->sourceDescription = $sourceDescription;
        $this->utm = $utm;
    }

    /**
     * @return UserId|null
     */
    public function getContactId(): ?UserId
    {
        return $this->contactId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getSecondName(): ?string
    {
        return $this->secondName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    /**
     * @return string|null
     */
    public function getComments(): ?string
    {
        return $this->comments;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getModified(): \DateTime
    {
        return $this->modified;
    }

    /**
     * @return PhoneNumber
     */
    public function getMobilePhone(): PhoneNumber
    {
        return $this->mobilePhone;
    }

    /**
     * @return Email|null
     */
    public function getEmail(): ?Email
    {
        return $this->email;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getOriginId(): ?string
    {
        return $this->originId;
    }

    /**
     * @return string|null
     */
    public function getOriginatorId(): ?string
    {
        return $this->originatorId;
    }

    /**
     * @return UTM|null
     */
    public function getUtm(): ?UTM
    {
        return $this->utm;
    }

    /**
     * @return string|null
     */
    public function getSourceDescription(): ?string
    {
        return $this->sourceDescription;
    }
}