<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Formatters;

use B24io\Loyalty\SDK\Transactions;
use B24io\Loyalty\SDK;

/**
 * Class Transaction
 *
 * @package B24io\Loyalty\SDK\Transactions\Formatters
 */
class Transaction
{
    /**
     * @param Transactions\DTO\TransactionInterface $transaction
     *
     * @return array
     */
    public static function toArray(Transactions\DTO\TransactionInterface $transaction): array
    {
        return [
            'operation_id' => $transaction->getOperationId()->getId(),
            'type' => $transaction->getType(),
            'card_number' => $transaction->getCardNumber(),
            'created' => $transaction->getCreated()->format(\DATE_ATOM),
            'value' => [
                'amount' => $transaction->getValue()->getAmount(),
                'currency' => $transaction->getValue()->getCurrency()->getCode(),
            ],
            'reason' => SDK\Transport\Formatters\Reason::toArray($transaction->getReason()),
        ];
    }
}