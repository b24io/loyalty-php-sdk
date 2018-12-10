<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class ChangePercentage
 *
 * @package B24io\Loyalty\SDK\Cards\Formatters
 */
class ChangePercentage
{
    /**
     * @param SDK\Cards\Operations\ChangePercentage $changePercentage
     *
     * @return array
     */
    public static function toArray(SDK\Cards\Operations\ChangePercentage $changePercentage): array
    {
        return [
            'timestamp' => $changePercentage->getCreated()->format(\DATE_ATOM),
            'operation_code' => $changePercentage->getOperationCode(),
            'card_number' => $changePercentage->getCardNumber(),
            'reason' => SDK\Transport\Formatters\Reason::toArray($changePercentage->getReason()),
            'percentage' => (string)$changePercentage->getPercentage(),
        ];
    }
}