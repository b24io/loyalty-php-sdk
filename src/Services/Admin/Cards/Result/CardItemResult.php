<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Cards\Result;

use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use B24io\Loyalty\SDK\Services\Admin\Cards\CardStatus;
use DateTimeInterface;
use Money\Money;
use Money\Currency;
use Symfony\Component\Uid\Uuid;

/**
 * @property-read Uuid $id
 * @property-read string $number
 * @property-read string $barcode
 * @property-read Money $balance
 * @property-read CardStatus $status
 */
class CardItemResult extends AbstractItem
{
    public function __get(int|string $offset)
    {
        switch ($offset) {
            case 'number':
                return (string)$this->data[$offset];
            case 'balance':
                return new Money(
                    (int)$this->data[$offset]['amount'],
                    new Currency((string)$this->data[$offset]['currency']
                    ));
            case 'status':
                return CardStatus::from($this->data[$offset]);
            default:
                return parent::__get($offset);
        }

    }

}