<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin;

use B24io\Loyalty\SDK\Services\AbstractServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Cards\Cards;
use B24io\Loyalty\SDK\Services\Admin\Contacts\Contacts;
use B24io\Loyalty\SDK\Services\Admin\Main\Main;
use B24io\Loyalty\SDK\Services\Admin\Transactions\Transactions;

class AdminServiceBuilder extends AbstractServiceBuilder
{
    public function main(): Main
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Main($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function cards(): Cards
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Cards($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function transactions(): Transactions
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Transactions($this->core, $this->log);
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