<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Formatters\Cards;

use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

/**
 * @readonly
 */
class CardItemFormatter
{
    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'card_id',
            'card_number',
            'card_status',
            'card_barcode',
            'card_balance',
            'card_iso_currency_code',
            'card_created',
            'card_modified',
        ];
    }

    /**
     * @param CardItemResult $card
     * @return array<string, mixed>
     */
    public function toFlatArray(CardItemResult $card): array
    {
        $decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());

        return
            [
                'card_id' => $card->id->toRfc4122(),
                'card_number' => $card->number,
                'card_status' => (string)$card->status,
                'card_barcode' => $card->barcode,
                'card_balance' => $decimalMoneyFormatter->format($card->balance),
                'card_iso_currency_code' => $card->balance->getCurrency()->getCode(),
                'card_created' => $card->created->format(DATE_ATOM),
                'card_modified' => $card->modified->format(DATE_ATOM),
            ];
    }
}