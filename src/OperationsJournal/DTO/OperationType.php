<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class OperationType
 *
 * @method ACCRUAL_TRANSACTION();
 * @method PAYMENT_TRANSACTION();
 * @method CREATE_CARD();
 * @method BLOCK_CARD();
 * @method UNBLOCK_CARD();
 * @method DELETE_CARD();
 * @method DECREMENT_PERCENT();
 * @method INCREMENT_PERCENT();
 * @method PURCHASE();
 *
 * @package B24io\Loyalty\SDK\Transport\Operations
 */
class OperationType extends AbstractEnumeration
{
    public const ACCRUAL_TRANSACTION = 'accrual_transaction';
    public const PAYMENT_TRANSACTION = 'payment_transaction';
    public const CREATE_CARD = 'create_card';
    public const BLOCK_CARD = 'block_card';
    public const UNBLOCK_CARD = 'unblock_card';
    public const DELETE_CARD = 'delete_card';
    public const DECREMENT_PERCENT = 'decrement_percent';
    public const INCREMENT_PERCENT = 'increment_percent';
    public const PURCHASE = 'purchase';
    public const BITRIX24_DEAL_MONETARY_DISCOUNT_PAYMENT_TRANSACTION = 'b24_deal_monetary_discount_payment_trx';
    public const BITRIX24_DEAL_PERCENTAGE_DISCOUNT_PAYMENT_TRANSACTION = 'b24_deal_percentage_discount_payment_trx';
}