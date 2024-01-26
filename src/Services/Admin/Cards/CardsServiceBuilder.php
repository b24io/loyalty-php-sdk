<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Cards;

use B24io\Loyalty\SDK\Services\AbstractServiceBuilder;

class CardsServiceBuilder extends AbstractServiceBuilder
{
    public function cards(): Cards
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new Cards(
                $this->core,
                $this->log);
        }

        return $this->serviceCache[__METHOD__];
    }

    public function fetcher(): CardsFetcher
    {
        if (!isset($this->serviceCache[__METHOD__])) {
            $this->serviceCache[__METHOD__] = new CardsFetcher(
                new Cards(
                    $this->core,
                    $this->log
                ),
                $this->log
            );
        }

        return $this->serviceCache[__METHOD__];
    }
}