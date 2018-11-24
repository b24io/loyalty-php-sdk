<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class UnblockCard
 *
 * @package B24io\Loyalty\SDK\Cards\Formatters
 */
class UnblockCard
{
    /**
     * @param SDK\Cards\Operations\UnblockCard $blockCard
     *
     * @return array
     */
    public static function toArray(SDK\Cards\Operations\UnblockCard $blockCard): array
    {
        return [
            'timestamp' => $blockCard->getTimestamp()->format(\DATE_ATOM),
            'operation_code' => $blockCard->getOperationCode(),
            'card_number' => $blockCard->getCardNumber(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($blockCard->getReason()),
        ];
    }
}