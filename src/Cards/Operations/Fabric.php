<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;

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
            ->setTimestamp(new \DateTime($arBlockCardOperation['timestamp']))
            ->setOperationCode($arBlockCardOperation['operation_code'])
            ->setCardNumber((int)$arBlockCardOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arBlockCardOperation['reason']));

        return $blockCardOperation;
    }

    /**
     * @param array $arDeleteCardOperation
     *
     * @return DeleteCard
     * @throws \Exception
     */
    public static function initDeleteCardOperationFromArray(array $arDeleteCardOperation): DeleteCard
    {
        $deleteCardOperation = new DeleteCard();
        $deleteCardOperation
            ->setTimestamp(new \DateTime($arDeleteCardOperation['timestamp']))
            ->setOperationCode($arDeleteCardOperation['operation_code'])
            ->setCardNumber((int)$arDeleteCardOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arDeleteCardOperation['reason']));

        return $deleteCardOperation;
    }

    /**
     * @param array $arUnblockCardOperation
     *
     * @return UnblockCard
     * @throws \Exception
     */
    public static function initUnblockCardOperationFromArray(array $arUnblockCardOperation): UnblockCard
    {
        $blockCardOperation = new UnblockCard();
        $blockCardOperation
            ->setTimestamp(new \DateTime($arUnblockCardOperation['timestamp']))
            ->setOperationCode($arUnblockCardOperation['operation_code'])
            ->setCardNumber((int)$arUnblockCardOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arUnblockCardOperation['reason']));

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
            ->setTimestamp(new \DateTime())
            ->setOperationCode('block-card')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $blockCardOperation;
    }

    /**
     * @param int    $cardNumber
     * @param Reason $reason
     *
     * @return UnblockCard
     * @throws \Exception
     */
    public static function createUnblockCardOperation(int $cardNumber, Reason $reason): UnblockCard
    {
        $unblockCardOperation = new UnblockCard();
        $unblockCardOperation
            ->setTimestamp(new \DateTime())
            ->setOperationCode('unblock-card')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $unblockCardOperation;
    }

    /**
     * @param int    $cardNumber
     * @param Reason $reason
     *
     * @return DeleteCard
     * @throws \Exception
     */
    public static function createDeleteCardOperation(int $cardNumber, Reason $reason): DeleteCard
    {
        $unblockCardOperation = new DeleteCard();
        $unblockCardOperation
            ->setTimestamp(new \DateTime())
            ->setOperationCode('delete-card')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $unblockCardOperation;
    }
}