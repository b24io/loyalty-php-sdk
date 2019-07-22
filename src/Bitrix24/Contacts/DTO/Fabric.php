<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Users;
use Money\Currency;
use Money\Money;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class Fabric
{
    /**
     * @param array $contact
     *
     * @return Contact
     */
    public static function initFromArray(array $contact): Contact
    {
        $newContact = new Contact();


        return $newContact;
    }
}