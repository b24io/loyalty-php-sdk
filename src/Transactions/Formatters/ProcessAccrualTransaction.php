<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Formatters;

use B24io\Loyalty\SDK\Transactions;
use B24io\Loyalty\SDK;

/**
 * Class ProcessAccrualTransaction
 *
 * @package B24io\Loyalty\SDK\Transactions\Formatters
 */
class ProcessAccrualTransaction
{
    /**
     * @param Transactions\Operations\ProcessAccrualTransaction $operation
     *
     * @return array
     */
    public static function toArray(Transactions\Operations\ProcessAccrualTransaction $operation): array
    {
        return [
            'operation_code' => $operation->getOperationCode(),
            'card_number' => $operation->getCardNumber(),
            'created' => $operation->getCreated()->format(\DATE_ATOM),
            'value' => [
                'amount' => $operation->getValue()->getAmount(),
                'currency' => $operation->getValue()->getCurrency()->getCode(),
            ],
            'reason' => SDK\Transport\Formatters\Reason::toArray($operation->getReason()),
        ];
    }
}