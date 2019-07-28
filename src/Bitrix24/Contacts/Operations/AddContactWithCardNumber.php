<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Operations;

use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Contact;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperationWithCard;

/**
 * Class AddContact
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Operations
 */
class AddContactWithCardNumber extends AbstractOperationWithCard
{
    /**
     * @var Contact
     */
    private $contact;

    /**
     * @param string $operationCode
     *
     * @return AddContactWithCardNumber
     */
    public function setOperationCode(string $operationCode): AddContactWithCardNumber
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $created
     *
     * @return AddContactWithCardNumber
     */
    public function setCreated(\DateTime $created): AddContactWithCardNumber
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return AddContactWithCardNumber
     */
    public function setReason(Reason $reason): AddContactWithCardNumber
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * @return Contact
     */
    public function getContact(): Contact
    {
        return $this->contact;
    }

    /**
     * @param Contact $contact
     *
     * @return AddContactWithCardNumber
     */
    public function setContact(Contact $contact): AddContactWithCardNumber
    {
        $this->contact = $contact;

        return $this;
    }
}