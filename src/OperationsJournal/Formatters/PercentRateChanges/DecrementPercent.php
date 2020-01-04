<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\PercentRateChanges;

use B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges\DecrementPercent as DecrementPercentDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class DecrementPercent
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions
 */
class DecrementPercent
{
    /**
     * @param DecrementPercentDto $operationDto
     *
     * @return array
     */
    public static function toArray(DecrementPercentDto $operationDto): array
    {
        return [
            'operation_type' => $operationDto->getOperationType()->value(),
            'percentage'     => (string)$operationDto->getPercentage(),
            'uuid'           => $operationDto->getUuid()->toString(),
            'card'           => [
                'uuid' => $operationDto->getCardUuid()->toString(),
            ],
            'user'           => [
                'user_id' => $operationDto->getUserId()->getId(),
            ],
            'timestamp'      => $operationDto->getTimestamp()->format(\DATE_ATOM),
            'reason'         => Reason::toArray($operationDto->getReason()),
        ];
    }
}