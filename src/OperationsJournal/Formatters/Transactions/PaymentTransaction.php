<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions;

use B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions\PaymentTransaction as PaymentTrxDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class PaymentTransaction
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions
 */
class PaymentTransaction
{
    /**
     * @param PaymentTrxDto $paymentTrx
     *
     * @return array
     */
    public static function toArray(PaymentTrxDto $paymentTrx): array
    {
        return [
            'operation_type' => $paymentTrx->getOperationType()->value(),
            'value'          => [
                'amount'   => $paymentTrx->getValue()->getAmount(),
                'currency' => $paymentTrx->getValue()->getCurrency()->getCode(),
            ],
            'uuid'           => $paymentTrx->getUuid()->toString(),
            'card'           => [
                'uuid' => $paymentTrx->getCardUuid()->toString(),
            ],
            'user'           => [
                'user_id' => $paymentTrx->getUserId()->getId(),
            ],
            'timestamp'      => $paymentTrx->getTimestamp()->format(\DATE_ATOM),
            'reason'         => Reason::toArray($paymentTrx->getReason()),
        ];
    }
}