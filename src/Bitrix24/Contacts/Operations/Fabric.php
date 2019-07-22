<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
class Fabric
{
    /**
     * @param array $arBlockCardOperation
     *
     * @return BlockCard
     * @throws \Exception
     */
    public static function initBlockCardOperationFromArray(array $arBlockCardOperation): BlockCard
    {
        $blockCardOperation = new BlockCard();
        $blockCardOperation
            ->setCreated(new \DateTime($arBlockCardOperation['timestamp']))
            ->setOperationCode($arBlockCardOperation['operation_code'])
            ->setCardNumber((int)$arBlockCardOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arBlockCardOperation['reason']));

        return $blockCardOperation;
    }

    /**
     * @param int    $cardNumber
     * @param Reason $reason
     *
     * @return BlockCard
     * @throws \Exception
     */
    public static function createBlockCardOperation(int $cardNumber, Reason $reason): BlockCard
    {
        $blockCardOperation = new BlockCard();
        $blockCardOperation
            ->setCreated(new \DateTime())
            ->setOperationCode('block-card')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $blockCardOperation;
    }
}