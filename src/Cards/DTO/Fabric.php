<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Users;
use Money\Currency;
use Money\Money;

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
        $newCard = new Card();
        $newCard
            ->setNumber((int)$card['number'])
            ->setBarcode((string)$card['barcode'])
            ->setStatus(Cards\DTO\Statuses\Fabric::initByStatusCode($card['status']))
            ->setUser(Users\DTO\Fabric::initFromArray($card['user']))
            ->setBalance(new Money((string)$card['balance']['amount'], new Currency($card['balance']['currency'])))
            ->setPercentage(new Percentage((string)$card['percentage']))
            ->setCreated(new \DateTime($card['created']))
            ->setModified(new \DateTime($card['modified']));

        return $newCard;
    }
}