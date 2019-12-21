<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class OperationType
 *
 * @method ACCRUAL_TRANSACTION();
 * @method PAYMENT_TRANSACTION();
 *
 * @package B24io\Loyalty\SDK\Transport\Operations
 */
class OperationType extends AbstractEnumeration
{
    public const ACCRUAL_TRANSACTION = 'accrual_transaction';
    public const PAYMENT_TRANSACTION = 'payment_transaction';
}