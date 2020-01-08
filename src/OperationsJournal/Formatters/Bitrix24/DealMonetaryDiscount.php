<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\Bitrix24;

use B24io\Loyalty\SDK\OperationsJournal\DTO\Bitrix24\DealMonetaryDiscount as DealMonetaryDiscountDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class DealMonetaryDiscount
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Formatters\Bitrix24
 */
class DealMonetaryDiscount
{
    /**
     * @param DealMonetaryDiscountDto $operation
     *
     * @return array
     */
    public static function toArray(DealMonetaryDiscountDto $operation): array
    {
        return [
            'operation_type' => $operation->getOperationType()->value(),
            'deal'           => [
                'id' => $operation->getDealId(),
            ],
            'value'          => [
                'amount'   => $operation->getValue()->getAmount(),
                'currency' => $operation->getValue()->getCurrency()->getCode(),
            ],
            'uuid'           => $operation->getUuid()->toString(),
            'card'           => [
                'uuid' => $operation->getCardUuid()->toString(),
            ],
            'user'           => [
                'user_id' => $operation->getUserId()->getId(),
            ],
            'timestamp'      => $operation->getTimestamp()->format(\DATE_ATOM),
            'reason'         => Reason::toArray($operation->getReason()),
        ];
    }
}