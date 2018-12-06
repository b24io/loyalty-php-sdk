<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\DTO;

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
     * @return Turnover
     * @throws \Exception
     */
    public static function initFromArray(array $card): Turnover
    {
        $newTurnover = new Turnover();
        $newTurnover
            ->setModified(new \DateTime($card['modified']))
            ->setTotalPurchasesSum(new Money((string)$card['total_purchases_sum']['amount'], new Currency($card['total_purchases_sum']['currency'])))
            ->setTotalPurchasesCount((int)$card['total_purchases_count']);

        return $newTurnover;
    }
}