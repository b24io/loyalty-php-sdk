<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class Turnover
 *
 * @package B24io\Loyalty\SDK\Turnover\Formatters
 */
class Turnover
{
    /**
     * @param SDK\Turnover\DTO\Turnover $turnover
     *
     * @return array
     */
    public static function toArray(SDK\Turnover\DTO\Turnover $turnover): array
    {
        return [
            'modified' => $turnover->getModified()->format(\DATE_ATOM),
            'total_purchases_sum' => [
                'amount' => $turnover->getTotalPurchasesSum()->getAmount(),
                'currency' => $turnover->getTotalPurchasesSum()->getCurrency()->getCode(),
            ],
            'total_purchases_count' => $turnover->getTotalPurchasesCount(),
        ];
    }
}