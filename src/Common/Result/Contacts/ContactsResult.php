<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Contacts;

use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Core\Result\AbstractResult;

class ContactsResult extends AbstractResult
{
    /**
     * @throws BaseException
     * @return ContactItemResult[]
     */
    public function getContacts(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->result as $contact) {
            $res[] = new ContactItemResult($contact);
        }

        return $res;
    }
}