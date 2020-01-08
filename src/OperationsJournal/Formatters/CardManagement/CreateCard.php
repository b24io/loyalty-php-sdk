<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement;

use B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement\CreateCard as CreateCardDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class CreateCard
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement
 */
class CreateCard
{
    /**
     * @param CreateCardDto $operation
     *
     * @return array
     */
    public static function toArray(CreateCardDto $operation): array
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