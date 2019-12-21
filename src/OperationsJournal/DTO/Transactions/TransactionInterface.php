<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions;

use \Money\Money;

/**
 * Interface TransactionInterface
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\Transactions
 */
interface TransactionInterface
{
    /**
     * @return Money
     */
    public function getValue(): Money;
}