<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters;

use B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions\AccrualTransaction;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions\PaymentTransaction;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationsJournal as OperationsJournalDto;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;

/**
 * Class OperationsJournal
 *
 * @package B24\Loyalty\OperationsJournal\Formatters
 */
class OperationsJournal
{
    /**
     * @param OperationsJournalDto $journal
     *
     * @return array
     */
    public static function toArray(OperationsJournalDto $journal): array
    {
        $arOperations = [];
        foreach ($journal->getOperations() as $operation) {
            switch ((string)$operation->getOperationType()->value()) {
                case OperationType::ACCRUAL_TRANSACTION:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions\AccrualTransaction
                     */
                    $arOperations[] = AccrualTransaction::toArray($operation);
                    break;
                case OperationType::PAYMENT_TRANSACTION:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions\PaymentTransaction
                     */
                    $arOperations[] = PaymentTransaction::toArray($operation);
                    break;
                default:
                    break;
            }
        }

        return [
            'date_from'  => $journal->getDateFrom()->format(\DATE_ATOM),
            'date_to'    => $journal->getDateTo()->format(\DATE_ATOM),
            'operations' => $arOperations,
        ];
    }
}