<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class BlockCard
 *
 * @package B24io\Loyalty\SDK\Cards\Formatters
 */
class BlockCard
{
    /**
     * @param SDK\Cards\Operations\BlockCard $blockCard
     *
     * @return array
     */
    public static function toArray(SDK\Cards\Operations\BlockCard $blockCard):array
    {
        return [
            'timestamp' => $blockCard->getCreated()->format(\DATE_ATOM),
            'operation_code' => $blockCard->getOperationCode(),
            'card_number' => $blockCard->getCardNumber(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($blockCard->getReason())
        ];
    }
}