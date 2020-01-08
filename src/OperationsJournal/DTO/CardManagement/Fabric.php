<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement;

use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\CardManagement
 */
class Fabric
{
    /**
     * @param array $arOperation
     *
     * @return BlockCard
     * @throws \Exception
     */
    public static function initBlockCardFromArray(array $arOperation): BlockCard
    {
        return new BlockCard(
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
     * @return CreateCard
     * @throws \Exception
     */
    public static function initCreateCardFromArray(array $arOperation): CreateCard
    {
        return new CreateCard(
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
     * @return DeleteCard
     * @throws \Exception
     */
    public static function initDeleteCardFromArray(array $arOperation): DeleteCard
    {
        return new DeleteCard(
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
     * @return UnblockCard
     * @throws \Exception
     */
    public static function initUnblockCardFromArray(array $arOperation): UnblockCard
    {
        return new UnblockCard(
            Uuid::fromString($arOperation['uuid']),
            Uuid::fromString($arOperation['card']['uuid']),
            new UserId((int)$arOperation['user']['user_id']),
            new \DateTime($arOperation['timestamp']),
            Reason::initReasonFromArray($arOperation['reason'])
        );
    }
}