<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\Operations;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use B24io\Loyalty\SDK\Users\DTO\UserId;
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
     * @param array $arBlockCardOperation
     *
     * @return ProcessPurchase
     * @throws \Exception
     */
    public static function initProcessPurchaseOperationFromArray(array $arBlockCardOperation): ProcessPurchase
    {
        $blockCardOperation = new ProcessPurchase();
        $blockCardOperation
            ->setTimestamp(new \DateTime($arBlockCardOperation['timestamp']))
            ->setAmount(new Money($arBlockCardOperation['purchase_amount']['amount'], new Currency($arBlockCardOperation['purchase_amount']['currency'])))
            ->setOperationCode($arBlockCardOperation['operation_code'])
            ->setCardNumber((int)$arBlockCardOperation['card_number'])
            ->setReason(Reason::initReasonFromArray($arBlockCardOperation['reason']));

        return $blockCardOperation;
    }

    /**
     * @param int    $cardNumber
     * @param Money  $amount
     * @param Reason $reason
     *
     * @return ProcessPurchase
     * @throws \Exception
     */
    public static function createProcessPurchaseOperation(int $cardNumber, Money $amount, Reason $reason): ProcessPurchase
    {
        $blockCardOperation = new ProcessPurchase();
        $blockCardOperation
            ->setTimestamp(new \DateTime())
            ->setAmount($amount)
            ->setOperationCode('process-purchase')
            ->setCardNumber($cardNumber)
            ->setReason($reason);

        return $blockCardOperation;
    }
}