<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin;

use B24io\Loyalty\SDK\Services\AbstractServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Cards\Cards;
use B24io\Loyalty\SDK\Services\Admin\Main\Main;

class AdminServiceBuilder extends AbstractServiceBuilder
{
    public function getMain(): Main
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Main($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function getCards(): Cards
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Cards($this->core, $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }
}