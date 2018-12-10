<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\DTO;

use B24io\Loyalty\SDK\Transport\DTO\OperationId;
use B24io\Loyalty\SDK;
use Money\Currency;
use Money\Money;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Transactions\DTO
 */
class Fabric
{
    /**
     * @param array $transaction
     *
     * @return AccrualTransaction
     * @throws \Exception
     */
    public static function initAccrualTransactionFromArray(array $transaction): AccrualTransaction
    {
        $newTrx = new AccrualTransaction();
        $newTrx
            ->setOperationId(new OperationId((string)$transaction['operation_id']))
            ->setValue(new Money((string)$transaction['value']['amount'], new Currency($transaction['value']['currency'])))
            ->setType($transaction['type'])
            ->setReason(SDK\Transport\DTO\Reason::initReasonFromArray($transaction['reason']))
            ->setCreated(new \DateTime($transaction['created']))
            ->setCardNumber($transaction['card_number']);

        return $newTrx;
    }

    /**
     * @param array $transaction
     *
     * @return PaymentTransaction
     * @throws \Exception
     */
    public static function initPaymentTransactionFromArray(array $transaction): PaymentTransaction
    {
        $newTrx = new PaymentTransaction();
        $newTrx
            ->setOperationId(new OperationId((string)$transaction['operation_id']))
            ->setValue(new Money((string)$transaction['value']['amount'], new Currency($transaction['value']['currency'])))
            ->setType($transaction['type'])
            ->setReason(SDK\Transport\DTO\Reason::initReasonFromArray($transaction['reason']))
            ->setCreated(new \DateTime($transaction['created']))
            ->setCardNumber($transaction['card_number']);

        return $newTrx;
    }
}