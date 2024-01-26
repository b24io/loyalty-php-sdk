<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

enum TransactionType: string
{
    case accrual = 'accrual';
    case payment = 'payment';
}