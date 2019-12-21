<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

/**
 * Class Fabric
 *
 * @package B24\Loyalty\Operations\DTO\Transactions
 */
class Fabric
{
    /**
     * @param array $arTrx
     *
     * @return AccrualTransaction
     * @throws \Exception
     */
    public static function initAccrualTransactionFromArray(array $arTrx): AccrualTransaction
    {
        return new AccrualTransaction(
            new Money((string)$arTrx['value']['amount'], new Currency($arTrx['value']['currency'])),
            Uuid::fromString($arTrx['uuid']),
            Uuid::fromString($arTrx['card']['uuid']),
            new UserId((int)$arTrx['user']['user_id']),
            new \DateTime($arTrx['timestamp']),
            Reason::initReasonFromArray($arTrx['reason'])
        );
    }

    /**
     * @param array $arTrx
     *
     * @return PaymentTransaction
     * @throws \Exception
     */
    public static function initPaymentTransactionFromArray(array $arTrx): PaymentTransaction
    {
        return new PaymentTransaction(
            new Money((string)$arTrx['value']['amount'], new Currency($arTrx['value']['currency'])),
            Uuid::fromString($arTrx['uuid']),
            Uuid::fromString($arTrx['card']['uuid']),
            new UserId((int)$arTrx['user']['user_id']),
            new \DateTime($arTrx['timestamp']),
            Reason::initReasonFromArray($arTrx['reason'])
        );
    }
}