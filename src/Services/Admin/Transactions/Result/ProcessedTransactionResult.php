<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions\Result;

use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use B24io\Loyalty\SDK\Core\Result\AbstractResult;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardItemResult;

class ProcessedTransactionResult extends AbstractResult
{
    public function getCard(): CardItemResult
    {
        return new CardItemResult($this->getCoreResponse()->getResponseData()->result['card']);
    }

    public function getTransaction(): TransactionItemResult
    {
        return new TransactionItemResult($this->getCoreResponse()->getResponseData()->result['transaction']);
    }
}