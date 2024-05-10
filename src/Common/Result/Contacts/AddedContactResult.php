<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Contacts;

use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Core\Result\AbstractResult;

class AddedContactResult extends AbstractResult
{
    /**
     * @return ContactItemResult
     * @throws BaseException
     */
    public function getContact(): ContactItemResult
    {
        return new ContactItemResult($this->getCoreResponse()->getResponseData()->result['contact']);
    }
}