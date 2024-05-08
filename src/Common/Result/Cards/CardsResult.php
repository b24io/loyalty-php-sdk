<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Cards;

use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Core\Result\AbstractResult;

class CardsResult extends AbstractResult
{
    /**
     * @return CardItemResult[]
     * @throws BaseException
     */
    public function getCards(): array
    {
        $res = [];
        foreach ($this->getCoreResponse()->getResponseData()->result as $card) {
            $res[] = new CardItemResult($card);
        }

        return $res;
    }
}