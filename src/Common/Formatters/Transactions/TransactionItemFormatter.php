<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Formatters\Transactions;

use B24io\Loyalty\SDK\Common\Result\Transactions\TransactionItemResult;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

/**
 * @readonly
 */
class TransactionItemFormatter
{
    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'transaction_id',
            'transaction_amount',
            'transaction_iso_currency_code',
            'transaction_type',
            'transaction_created',
            'transaction_reason_id',
            'transaction_reason_code',
            'transaction_reason_comment',
            'card_id',
            'card_number',
        ];
    }

    /**
     * @param TransactionItemResult $trx
     * @return array<string, mixed>
     */
    public function toFlatArray(TransactionItemResult $trx): array
    {
        $decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        return [
            'transaction_id' => $trx->id->toRfc4122(),
            'transaction_amount' => $decimalMoneyFormatter->format($trx->value),
            'transaction_iso_currency_code' => $trx->value->getCurrency()->getCode(),
            'transaction_type' => $trx->type,
            'transaction_created' => $trx->created->format(DATE_ATOM),
            'transaction_reason_id' => $trx->reason->id,
            'transaction_reason_code' => $trx->reason->code,
            'transaction_reason_comment' => $trx->reason->comment,
            'card_id' => $trx->cardId->toRfc4122(),
            'card_number' => $trx->cardNumber
        ];
    }
}