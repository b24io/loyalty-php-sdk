<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class ProcessPurchase
 *
 * @package B24io\Loyalty\SDK\Turnover\Formatters
 */
class ProcessPurchase
{
    /**
     * @param SDK\Turnover\Operations\ProcessPurchase $processPurchase
     *
     * @return array
     */
    public static function toArray(SDK\Turnover\Operations\ProcessPurchase $processPurchase): array
    {
        return [
            'timestamp' => $processPurchase->getCreated()->format(\DATE_ATOM),
            'operation_code' => $processPurchase->getOperationCode(),
            'card_number' => $processPurchase->getCardNumber(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($processPurchase->getReason()),
            'purchase_amount' => [
                'amount' => $processPurchase->getAmount()->getAmount(),
                'currency' => $processPurchase->getAmount()->getCurrency(),
            ],
        ];
    }
}