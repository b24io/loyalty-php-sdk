<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Cards;

use B24io\Loyalty\SDK\Core\Result\AbstractResult;

class AddedCardResult extends AbstractResult
{
    public function getCard(): CardItemResult
    {
        return new CardItemResult($this->getCoreResponse()->getResponseData()->result['card']);
    }
}