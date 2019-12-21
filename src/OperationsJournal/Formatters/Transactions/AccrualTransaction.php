<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions;

use B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions\AccrualTransaction as AccrualTrxDto;
use B24io\Loyalty\SDK\Transport\Formatters\Reason;

/**
 * Class AccrualTransaction
 *
 * @package B24\Loyalty\OperationsJournal\Formatters\Transactions
 */
class AccrualTransaction
{
    /**
     * @param AccrualTrxDto $accrualTrx
     *
     * @return array
     */
    public static function toArray(AccrualTrxDto $accrualTrx): array
    {
        return [
            'operation_type' => $accrualTrx->getOperationType()->value(),
            'value'          => [
                'amount'   => $accrualTrx->getValue()->getAmount(),
                'currency' => $accrualTrx->getValue()->getCurrency()->getCode(),
            ],
            'uuid'           => $accrualTrx->getUuid()->toString(),
            'card'           => [
                'uuid' => $accrualTrx->getCardUuid()->toString(),
            ],
            'user'           => [
                'user_id' => $accrualTrx->getUserId()->getId(),
            ],
            'timestamp'      => $accrualTrx->getTimestamp()->format(\DATE_ATOM),
            'reason'         => Reason::toArray($accrualTrx->getReason()),
        ];
    }
}