<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class DeleteCard
 *
 * @package B24io\Loyalty\SDK\Cards\Formatters
 */
class DeleteCard
{
    /**
     * @param SDK\Cards\Operations\DeleteCard $blockCard
     *
     * @return array
     */
    public static function toArray(SDK\Cards\Operations\DeleteCard $blockCard): array
    {
        return [
            'timestamp' => $blockCard->getTimestamp()->format(\DATE_ATOM),
            'operation_code' => $blockCard->getOperationCode(),
            'card_number' => $blockCard->getCardNumber(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($blockCard->getReason()),
        ];
    }
}