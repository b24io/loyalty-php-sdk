<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Formatters;

use B24io\Loyalty\SDK\Cards;

/**
 * Class Card
 *
 * @package B24io\Loyalty\SDK\Cards\Formatters
 */
class Card
{
    /**
     * @param Cards\DTO\Card $card
     *
     * @return array
     */
    public static function toArray(Cards\DTO\Card $card): array
    {
        return [
            'number'     => $card->getNumber(),
            'uuid'       => $card->getUuid()->toString(),
            'barcode'    => $card->getBarcode(),
            'status'     => $card->getStatus()->getCode(),
            'user'       => [
                'user-id' => $card->getUser()->getUserId()->getId(),
            ],
            'balance'    => [
                'amount'   => $card->getBalance()->getAmount(),
                'currency' => $card->getBalance()->getCurrency()->getCode(),
            ],
            'percentage' => (string)$card->getPercentage(),
            'created'    => $card->getCreated()->format(\DATE_ATOM),
            'modified'   => $card->getModified()->format(\DATE_ATOM),
        ];
    }
}