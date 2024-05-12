<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin;

use B24io\Loyalty\SDK\Services\AbstractServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Cards\CardsServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Contacts\ContactsServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Transactions\TransactionsServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Main\Main;

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

    public function contactsScope(): ContactsServiceBuilder
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new ContactsServiceBuilder(
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
}