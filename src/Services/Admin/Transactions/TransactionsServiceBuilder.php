<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions;

use B24io\Loyalty\SDK\Services\AbstractServiceBuilder;

class TransactionsServiceBuilder extends AbstractServiceBuilder
{
    public function transactions(): Transactions
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Transactions(
                $this->core,
                $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function fetcher(): TransactionsFetcher
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new TransactionsFetcher(
                new Transactions(
                    $this->core,
                    $this->log
                ),
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}