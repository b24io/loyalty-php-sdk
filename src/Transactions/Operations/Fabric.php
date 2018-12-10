<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use Money\Currency;
use Money\Money;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class Fabric
{
    /**
     * @param array $arAccrualTrxOperation
     *
     * @return ProcessAccrualTransaction
     * @throws \Exception
     */
    public static function initProcessAccrualTransactionFromArray(array $arAccrualTrxOperation): ProcessAccrualTransaction
    {
        $accrualTransaction = new ProcessAccrualTransaction();
        $accrualTransaction
            ->setTimestamp(new \DateTime($arAccrualTrxOperation['created']))
            ->setValue(new Money($arAccrualTrxOperation['value']['amount'], new Currency($arAccrualTrxOperation['value']['currency'])))
            ->setOperationCode($arAccrualTrxOperation['operation_code'])
            ->setCardNumber((int)$arAccrualTrxOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arAccrualTrxOperation['reason']));

        return $accrualTransaction;
    }

    /**
     * @param int    $cardNumber
     * @param Money  $amount
     * @param Reason $reason
     *
     * @return ProcessAccrualTransaction
     * @throws \Exception
     */
    public static function createProcessAccrualTransaction(int $cardNumber, Money $amount, Reason $reason): ProcessAccrualTransaction
    {
        $blockCardOperation = new ProcessAccrualTransaction();
        $blockCardOperation
            ->setTimestamp(new \DateTime())
            ->setValue($amount)
            ->setOperationCode('process-accrual-transaction')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $blockCardOperation;
    }

    /**
     * @param array $arAccrualTrxOperation
     *
     * @return ProcessPaymentTransaction
     * @throws \Exception
     */
    public static function initProcessPaymentTransactionFromArray(array $arAccrualTrxOperation): ProcessPaymentTransaction
    {
        $accrualTransaction = new ProcessPaymentTransaction();
        $accrualTransaction
            ->setTimestamp(new \DateTime($arAccrualTrxOperation['created']))
            ->setValue(new Money($arAccrualTrxOperation['value']['amount'], new Currency($arAccrualTrxOperation['value']['currency'])))
            ->setOperationCode($arAccrualTrxOperation['operation_code'])
            ->setCardNumber((int)$arAccrualTrxOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arAccrualTrxOperation['reason']));

        return $accrualTransaction;
    }

    /**
     * @param int    $cardNumber
     * @param Money  $amount
     * @param Reason $reason
     *
     * @return ProcessPaymentTransaction
     * @throws \Exception
     */
    public static function createProcessPaymentTransaction(int $cardNumber, Money $amount, Reason $reason): ProcessPaymentTransaction
    {
        $blockCardOperation = new ProcessPaymentTransaction();
        $blockCardOperation
            ->setTimestamp(new \DateTime())
            ->setValue($amount)
            ->setOperationCode('process-payment-transaction')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $blockCardOperation;
    }
}