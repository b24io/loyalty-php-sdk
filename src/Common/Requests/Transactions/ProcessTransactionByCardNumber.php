<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Requests\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;
use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Money;
use Money\Parser\DecimalMoneyParser;
use Symfony\Component\Uid\Uuid;

class ProcessTransactionByCardNumber
{
    /**
     * @readonly
     */
    public Uuid $cardId;
    /**
     * @readonly
     */
    public string $cardNumber;
    /**
     * @readonly
     */
    public Money $amount;
    /**
     * @readonly
     */
    public TransactionType $type;
    /**
     * @readonly
     */
    public Uuid $contactId;
    /**
     * @readonly
     */
    public Reason $reason;
    /**
     * @readonly
     */
    public ?string $contactExternalId = null;

    public function __construct(
        Uuid            $cardId,
        string          $cardNumber,
        Money           $amount,
        TransactionType $type,
        Uuid            $contactId,
        Reason          $reason,
        ?string         $contactExternalId = null)
    {
        $this->cardId = $cardId;
        $this->cardNumber = $cardNumber;
        $this->amount = $amount;
        $this->type = $type;
        $this->contactId = $contactId;
        $this->reason = $reason;
        $this->contactExternalId = $contactExternalId;
    }

    /**
     * @param array{'card_id':string, 'card_number':string, 'transaction_amount':string, 'transaction_iso_currency_code':non-empty-string, 'transaction_type': non-empty-string, 'contact_id':non-empty-string, 'contact_external_id':string, 'transaction_reason_id':non-empty-string,'transaction_reason_code':non-empty-string,'transaction_reason_comment':string } $newTrx
     * @return ProcessTransactionByCardNumber
     * @throws InvalidArgumentException
     */
    public static function initFromArray(array $newTrx): ProcessTransactionByCardNumber
    {
        $decimalMoneyParser = new DecimalMoneyParser(new ISOCurrencies());

        return new self(
            Uuid::fromString($newTrx['card_id']),
            $newTrx['card_number'],
            $decimalMoneyParser->parse($newTrx['transaction_amount'], new Currency($newTrx['transaction_iso_currency_code'])),
            new TransactionType($newTrx['transaction_type']),
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