<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Transactions;

use B24io\Loyalty\SDK\Core\Result\AbstractResult;

class TransactionsResult extends AbstractResult
{
    public function getTransactions(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->result as $trx) {
            $res[] = new TransactionItemResult($trx);
        }

        return $res;
    }
}