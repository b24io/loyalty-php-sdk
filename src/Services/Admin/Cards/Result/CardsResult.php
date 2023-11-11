<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Cards\Result;

use B24io\Loyalty\SDK\Core\Result\AbstractResult;

class CardsResult extends AbstractResult
{
    public function getCards(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->result as $card) {
            $res[] = new CardItemResult($card);
        }

        return $res;
    }
}