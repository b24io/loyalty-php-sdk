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
     * @param array $arDeleteCardOperation
     *
     * @return DeleteCard
     * @throws \Exception
     */
    public static function initDeleteCardOperationFromArray(array $arDeleteCardOperation): DeleteCard
    {
        $deleteCardOperation = new DeleteCard();
        $deleteCardOperation
            ->setCreated(new \DateTime($arDeleteCardOperation['timestamp']))
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
            ->setCreated(new \DateTime($arUnblockCardOperation['timestamp']))
            ->setOperationCode($arUnblockCardOperation['operation_code'])
            ->setCardNumber((int)$arUnblockCardOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arUnblockCardOperation['reason']));

        return $blockCardOperation;
    }

    /**
     * @param array $arChangePercentageOperation
     *
     * @return ChangePercentage
     * @throws \Exception
     */
    public static function initChangePercentageOperationFromArray(array $arChangePercentageOperation): ChangePercentage
    {
        $changePercentageOperation = new ChangePercentage();
        $changePercentageOperation
            ->setPercentage(new Percentage((string)$arChangePercentageOperation['percentage']))
            ->setCreated(new \DateTime($arChangePercentageOperation['timestamp']))
            ->setOperationCode($arChangePercentageOperation['operation_code'])
            ->setCardNumber((int)$arChangePercentageOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arChangePercentageOperation['reason']));

        return $changePercentageOperation;
    }

    /**
     * @param array $arAddCardOperation
     *
     * @return AddCard
     * @throws \Exception
     */
    public static function initAddCardOperationFromArray(array $arAddCardOperation): AddCard
    {
        $addCardOperation = new AddCard();
        $addCardOperation
            ->setCreated(new \DateTime($arAddCardOperation['timestamp']))
            ->setOperationCode($arAddCardOperation['operation_code'])
            ->setCardNumber((int)$arAddCardOperation['card_number'])
            ->setUserId(new UserId((int)$arAddCardOperation['user']['user_id']))
            ->setReason(Reason::initReasonFromArray($arAddCardOperation['reason']));

        return $addCardOperation;
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
            ->setCreated(new \DateTime())
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
            ->setCreated(new \DateTime())
            ->setOperationCode('delete-card')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $unblockCardOperation;
    }

    /**
     * @param int        $cardNumber
     * @param Reason     $reason
     * @param Percentage $percentage
     *
     * @return ChangePercentage
     * @throws \Exception
     */
    public static function createChangePercentageOperation(int $cardNumber, Reason $reason, Percentage $percentage): ChangePercentage
    {
        $changePercentageOperation = new ChangePercentage();
        $changePercentageOperation
            ->setCreated(new \DateTime())
            ->setPercentage($percentage)
            ->setOperationCode('change-percentage')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $changePercentageOperation;
    }

    /**
     * @param int    $cardNumber
     * @param Reason $reason
     * @param UserId $userId
     *
     * @return AddCard
     * @throws \Exception
     */
    public static function createAddCardOperation(int $cardNumber, Reason $reason, UserId $userId): AddCard
    {
        $addCardOperation = new AddCard();
        $addCardOperation
            ->setCreated(new \DateTime())
            ->setUserId($userId)
            ->setOperationCode('add-card')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $addCardOperation;
    }
}