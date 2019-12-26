<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO;

use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationCollection;
use B24io\Loyalty\SDK\OperationsJournal\DTO\OperationsJournal;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Money\Currency;
use Money\Money;
use Psr\Log\LoggerInterface;
use Ramsey\Uuid\Uuid;
use B24io\Loyalty\SDK;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions
 */
class Fabric
{
    /**
     * @param array $arOperationsJournal
     *
     * @return OperationsJournal
     * @throws \Exception
     */
    public static function initOperationsJournalFromArray(array $arOperationsJournal, LoggerInterface $logger): OperationsJournal
    {
        $operationCollection = new OperationCollection();

        foreach ($arOperationsJournal['operations'] as $cnt => $operation) {
            switch ($operation['operation_type']) {
                case OperationType::ACCRUAL_TRANSACTION:
                    $operationCollection->attach(
                        SDK\OperationsJournal\DTO\Transactions\Fabric::initAccrualTransactionFromArray($operation)
                    );
                    break;
                case OperationType::PAYMENT_TRANSACTION:
                    $operationCollection->attach(
                        SDK\OperationsJournal\DTO\Transactions\Fabric::initPaymentTransactionFromArray($operation)
                    );
                    break;
                default:
                    var_dump($operation);
                    $logger->warning(
                        'B24io.Loyalty.SDK.OperationsJournal.DTO.Fabric.initOperationsJournalFromArray.unknownOperationType',
                        [
                            'operationType' => $operation['operation_type'],
                            'operation'     => $operation,
                        ]
                    );
                    break;
            }
        }

        return new OperationsJournal(
            new \DateTime($arOperationsJournal['date_from']),
            new \DateTime($arOperationsJournal['date_to']),
            $operationCollection
        );
    }
}