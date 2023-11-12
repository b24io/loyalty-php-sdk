<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions\Result;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use B24io\Loyalty\SDK\Services\Admin\Cards\CardStatus;
use B24io\Loyalty\SDK\Services\Admin\Transactions\TransactionType;
use DateTimeImmutable;
use DateTimeInterface;
use Money\Money;
use Money\Currency;
use Symfony\Component\Uid\Uuid;

/**
 * @property-read Uuid $id
 * @property-read Uuid $cardId
 * @property-read Money $value
 * @property-read TransactionType $type
 * @property-read DateTimeImmutable $created
 * @property-read Reason $reason
 */
class TransactionItemResult extends AbstractItem
{
    public function __get(int|string $offset)
    {
        switch ($offset) {
            case 'value':
                return new Money(
                    (int)$this->data[$offset]['amount'],
                    new Currency((string)$this->data[$offset]['currency']
                    ));
            case 'type':
                return TransactionType::from($this->data[$offset]);
            case 'cardId':
                return Uuid::fromString($this->data['card']['id']);
            case 'cardNumber':
                return $this->data['card']['number'];
            default:
                return parent::__get($offset);
        }

    }
}