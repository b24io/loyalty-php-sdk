<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Purchases;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\Purchases
 */
class Fabric
{
    /**
     * @param array $arOperation
     *
     * @return Purchase
     * @throws \Exception
     */
    public static function initPurchaseFromArray(array $arOperation): Purchase
    {
        return new Purchase(
            new Money((string)$arOperation['sum']['amount'], new Currency($arOperation['sum']['currency'])),
            Uuid::fromString($arOperation['uuid']),
            Uuid::fromString($arOperation['card']['uuid']),
            new UserId((int)$arOperation['user']['user_id']),
            new \DateTime($arOperation['timestamp']),
            Reason::initReasonFromArray($arOperation['reason'])
        );
    }
}