<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Operations;

use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Contact;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Transport\Operations\AbstractOperation;

/**
 * Class AddContact
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Operations
 */
class AddContact extends AbstractOperation
{
    /**
     * @var Contact
     */
    private $contact;

    /**
     * @param string $operationCode
     *
     * @return AddContact
     */
    public function setOperationCode(string $operationCode): AddContact
    {
        $this->operationCode = $operationCode;

        return $this;
    }

    /**
     * @param \DateTime $created
     *
     * @return AddContact
     */
    public function setCreated(\DateTime $created): AddContact
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param Reason $reason
     *
     * @return AddContact
     */
    public function setReason(Reason $reason): AddContact
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
     * @return AddContact
     */
    public function setContact(Contact $contact): AddContact
    {
        $this->contact = $contact;

        return $this;
    }
}