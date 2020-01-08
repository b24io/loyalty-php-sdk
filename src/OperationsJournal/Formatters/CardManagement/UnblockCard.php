<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement;

use B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement\UnblockCard as UnblockCardDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class UnblockCard
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement
 */
class UnblockCard
{
    /**
     * @param UnblockCardDto $operation
     *
     * @return array
     */
    public static function toArray(UnblockCardDto $operation): array
    {
        return [
            'operation_type' => $operation->getOperationType()->value(),
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