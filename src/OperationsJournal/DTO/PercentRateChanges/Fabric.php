<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
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
     * @return DecrementPercent
     * @throws \Exception
     */
    public static function initDecrementPercentFromArray(array $arOperation): DecrementPercent
    {
        return new DecrementPercent(
            new Percentage((string)$arOperation['percentage']),
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
     * @return IncrementPercent
     * @throws \Exception
     */
    public static function initIncrementPercentFromArray(array $arOperation): IncrementPercent
    {
        return new IncrementPercent(
            new Percentage((string)$arOperation['percentage']),
            Uuid::fromString($arOperation['uuid']),
            Uuid::fromString($arOperation['card']['uuid']),
            new UserId((int)$arOperation['user']['user_id']),
            new \DateTime($arOperation['timestamp']),
            Reason::initReasonFromArray($arOperation['reason'])
        );
    }
}