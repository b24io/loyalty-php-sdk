<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\User;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Transactions\Transport\DTO\ContactResponse;

use Fig\Http\Message\RequestMethodInterface;
use libphonenumber\PhoneNumber;
use Money\Money;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Transactions\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @return ContactResponse
     */
    public function register(): ContactResponse
    {
        return new ContactResponse(new SDK\Transport\DTO\Metadata(), new SDK\Bitrix24\Contacts\DTO\Contact());
    }

    /**
     * @return ContactResponse
     */
    public function current(): ContactResponse
    {
        return new ContactResponse(new SDK\Transport\DTO\Metadata(), new SDK\Bitrix24\Contacts\DTO\Contact());
    }
}