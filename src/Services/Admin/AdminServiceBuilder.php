<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin;

use B24io\Loyalty\SDK\Services\AbstractServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Cards\Cards;
use B24io\Loyalty\SDK\Services\Admin\Cards\CardsFetcher;
use B24io\Loyalty\SDK\Services\Admin\Cards\CardsServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Contacts\Contacts;
use B24io\Loyalty\SDK\Services\Admin\Main\Main;
use B24io\Loyalty\SDK\Services\Admin\Transactions\Transactions;
use B24io\Loyalty\SDK\Services\Admin\Transactions\TransactionsServiceBuilder;

class AdminServiceBuilder extends AbstractServiceBuilder
{
    public function main(): Main
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Main($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function cardsScope(): CardsServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new CardsServiceBuilder(
                $this->core,
                $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function transactionsScope(): TransactionsServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new TransactionsServiceBuilder(
                $this->core,
                $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function contacts(): Contacts
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Contacts($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}