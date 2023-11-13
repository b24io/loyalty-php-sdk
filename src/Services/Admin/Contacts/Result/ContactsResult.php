<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Contacts\Result;

use B24io\Loyalty\SDK\Core\Result\AbstractResult;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardItemResult;

class ContactsResult extends AbstractResult
{
    public function getContacts(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->result as $contact) {
            $res[] = new ContactItemResult($contact);
        }

        return $res;
    }
}