<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\Purchases;

use B24io\Loyalty\SDK\OperationsJournal\DTO\Purchases\Purchase as PurchaseDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class Purchase
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Formatters\Purchases
 */
class Purchase
{
    /**
     * @param PurchaseDto $purchase
     *
     * @return array
     */
    public static function toArray(PurchaseDto $purchase): array
    {
        return [
            'operation_type' => $purchase->getOperationType()->value(),
            'sum'            => [
                'amount'   => $purchase->getSum()->getAmount(),
                'currency' => $purchase->getSum()->getCurrency()->getCode(),
            ],
            'uuid'           => $purchase->getUuid()->toString(),
            'card'           => [
                'uuid' => $purchase->getCardUuid()->toString(),
            ],
            'user'           => [
                'user_id' => $purchase->getUserId()->getId(),
            ],
            'timestamp'      => $purchase->getTimestamp()->format(\DATE_ATOM),
            'reason'         => Reason::toArray($purchase->getReason()),
        ];
    }
}