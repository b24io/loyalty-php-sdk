<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\Bitrix24;

use B24io\Loyalty\SDK\OperationsJournal\DTO\Bitrix24\DealPercentageDiscount as DealPercentageDiscountDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class DealPercentageDiscount
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Formatters\Bitrix24
 */
class DealPercentageDiscount
{
    /**
     * @param DealPercentageDiscountDto $operation
     *
     * @return array
     */
    public static function toArray(DealPercentageDiscountDto $operation): array
    {
        return [
            'operation_type' => $operation->getOperationType()->value(),
            'deal'           => [
                'id' => $operation->getDealId(),
            ],
            'percentage'     => (string)$operation->getPercentage(),
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