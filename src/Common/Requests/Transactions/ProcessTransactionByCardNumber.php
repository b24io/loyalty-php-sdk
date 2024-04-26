<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Requests\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use Symfony\Component\Uid\Uuid;

readonly class ProcessTransactionByCardNumber
{
    public function __construct(
        public Uuid            $cardId,
        public string          $cardNumber,
        public Money           $amount,
        public TransactionType $type,
        public Uuid            $contactId,
        public Reason          $reason,
        public ?string         $contactExternalId = null
    )
    {
    }

    /**
     * @param array{'card_id':string, 'card_number':string, 'transaction_amount':string, 'transaction_iso_currency_code':non-empty-string, 'transaction_type': non-empty-string, 'contact_id':non-empty-string, 'contact_external_id':string, 'transaction_reason_id':non-empty-string,'transaction_reason_code':non-empty-string,'transaction_reason_comment':string } $newTrx
     * @return ProcessTransactionByCardNumber
     */
    public static function initFromArray(array $newTrx): ProcessTransactionByCardNumber
    {
        $decimalMoneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return new self(
            Uuid::fromString($newTrx['card_id']),
            $newTrx['card_number'],
            $decimalMoneyParser->parse($newTrx['transaction_amount'], new Currency($newTrx['transaction_iso_currency_code'])),
            TransactionType::from($newTrx['transaction_type']),
            Uuid::fromString($newTrx['contact_id']),
            new Reason(
                $newTrx['transaction_reason_id'],
                $newTrx['transaction_reason_code'],
                $newTrx['transaction_reason_comment'],
            ),
            $newTrx['contact_external_id']
        );
    }
}