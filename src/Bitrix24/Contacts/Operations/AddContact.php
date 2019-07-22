<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Operations;

use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Contact;
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