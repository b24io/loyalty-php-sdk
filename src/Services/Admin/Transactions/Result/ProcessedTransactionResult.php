<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions\Result;

use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Core\Result\AbstractResult;

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