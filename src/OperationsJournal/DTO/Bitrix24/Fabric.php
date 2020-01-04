<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Bitrix24;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
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
     * @param array $arOperation
     *
     * @return DealMonetaryDiscount
     * @throws \Exception
     */
    public static function initDealMonetaryDiscountFromArray(array $arOperation): DealMonetaryDiscount
    {
        return new DealMonetaryDiscount(
            (int)$arOperation['deal']['id'],
            new Money((string)$arOperation['value']['amount'], new Currency($arOperation['value']['currency'])),
            Uuid::fromString($arOperation['uuid']),
            Uuid::fromString($arOperation['card']['uuid']),
            new UserId((int)$arOperation['user']['user_id']),
            new \DateTime($arOperation['timestamp']),
            Reason::initReasonFromArray($arOperation['reason'])
        );
    }

    /**
     * @param array $arOperation
     *
     * @return DealPercentageDiscount
     * @throws \Exception
     */
    public static function initDealPercentageDiscountFromArray(array $arOperation): DealPercentageDiscount
    {
        return new DealPercentageDiscount(
            (int)$arOperation['deal']['id'],
            new Percentage((string)$arOperation['percentage']),
            Uuid::fromString($arOperation['uuid']),
            Uuid::fromString($arOperation['card']['uuid']),
            new UserId((int)$arOperation['user']['user_id']),
            new \DateTime($arOperation['timestamp']),
            Reason::initReasonFromArray($arOperation['reason'])
        );
    }
}