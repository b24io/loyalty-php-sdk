<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions;

use B24io\Loyalty\SDK\Core\Result\AbstractResult;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardItemResult;

enum TransactionType: string
{
    case accrual = 'accrual_transaction';
    case payment = 'payment_transaction';
}