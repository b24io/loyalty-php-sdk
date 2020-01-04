<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\Formatters;

use B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement\BlockCard;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement\CreateCard;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement\DeleteCard;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\CardManagement\UnblockCard;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\PercentRateChanges\DecrementPercent;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\PercentRateChanges\IncrementPercent;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\Purchases\Purchase;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions\AccrualTransaction;
use B24io\Loyalty\SDK\OperationsJournal\Formatters\Transactions\PaymentTransaction;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationsJournal as OperationsJournalDto;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use Psr\Log\LoggerInterface;

/**
 * Class OperationsJournal
 *
 * @package B24\Loyalty\OperationsJournal\Formatters
 */
class OperationsJournal
{
    /**
     * @param OperationsJournalDto $journal
     * @param LoggerInterface      $logger
     *
     * @return array
     */
    public static function toArray(OperationsJournalDto $journal, LoggerInterface $logger): array
    {
        $arOperations = [];
        foreach ($journal->getOperations() as $operation) {
            switch ((string)$operation->getOperationType()->value()) {
                // transactions
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
                // card management
                case OperationType::CREATE_CARD:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement\CreateCard
                     */
                    $arOperations[] = CreateCard::toArray($operation);
                    break;
                case OperationType::DELETE_CARD:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement\DeleteCard
                     */
                    $arOperations[] = DeleteCard::toArray($operation);
                    break;
                case OperationType::BLOCK_CARD:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement\BlockCard
                     */
                    $arOperations[] = BlockCard::toArray($operation);
                    break;
                case OperationType::UNBLOCK_CARD:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement\UnblockCard
                     */
                    $arOperations[] = UnblockCard::toArray($operation);
                    break;
                // card percent rate changes
                case OperationType::DECREMENT_PERCENT:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges\DecrementPercent
                     */
                    $arOperations[] = DecrementPercent::toArray($operation);
                    break;
                case OperationType::INCREMENT_PERCENT:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges\IncrementPercent
                     */
                    $arOperations[] = IncrementPercent::toArray($operation);
                    break;
                // purchase registration
                case OperationType::PURCHASE:
                    /**
                     * @var $operation \B24io\Loyalty\SDK\OperationsJournal\DTO\Purchases\Purchase
                     */
                    $arOperations[] = Purchase::toArray($operation);
                    break;
                default:
                    $logger->warning(
                        'B24io.Loyalty.SDK.OperationsJournal.Formatters.OperationsJournal.toArray.unknownOperationType',
                        [
                            'operationType' => (string)$operation->getOperationType()->value(),
                            'operationUuid' => $operation->getUuid()->toString(),
                        ]
                    );
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