<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class AddCard
 *
 * @package B24io\Loyalty\SDK\Cards\Formatters
 */
class AddCard
{
    /**
     * @param SDK\Cards\Operations\AddCard $addCard
     *
     * @return array
     */
    public static function toArray(SDK\Cards\Operations\AddCard $addCard): array
    {
        return [
            'timestamp' => $addCard->getCreated()->format(\DATE_ATOM),
            'operation_code' => $addCard->getOperationCode(),
            'card_number' => $addCard->getCardNumber(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($addCard->getReason()),
            'user' => [
                'user_id' => $addCard->getUserId()->getId(),
            ],
        ];
    }
}