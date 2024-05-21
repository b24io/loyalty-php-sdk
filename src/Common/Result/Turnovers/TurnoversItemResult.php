<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Turnovers;

use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use Money\Currency;
use Money\Money;

/**
 * @property-read int $totalPurchasesCount
 * @property-read Money $totalPurchasesSum
 */
class TurnoversItemResult extends AbstractItem
{
    public function __get(int|string $offset)
    {
        switch ($offset) {
            case 'totalPurchasesCount':
                return (int)$this->data['total_purchases_count'];
            case 'totalPurchasesSum':
                return $this->decimalMoneyParser->parse(
                    $this->data['total_purchases_sum']['amount'],
                    new Currency($this->data['total_purchases_sum']['currency'] ?? '')
                );
            default:
                return parent::__get($offset);
        }
    }
}