<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Users;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Cards\DTO
 */
class Fabric
{
    /**
     * @param array $card
     *
     * @return Card
     * @throws \B24io\Loyalty\SDK\Exceptions\BaseLoyaltyException
     */
    public static function initFromArray(array $card): Card
    {
        return new Card(
            (int)$card['number'],
            (string)$card['barcode'],
            Cards\DTO\Statuses\Fabric::initByStatusCode($card['status']),
            Users\DTO\Fabric::initFromArray($card['user']),
            new Money((string)$card['balance']['amount'], new Currency($card['balance']['currency'])),
            new Percentage((string)$card['percentage']),
            new \DateTime($card['created']),
            new \DateTime($card['modified']),
            Uuid::fromString($card['uuid'])
        );
    }
}