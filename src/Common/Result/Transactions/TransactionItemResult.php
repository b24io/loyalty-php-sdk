<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use Symfony\Component\Uid\Uuid;

/**
 * @property-read Uuid $id
 * @property-read Uuid $cardId
 * @property-read string $cardNumber
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
                return $this->decimalMoneyParser->parse(
                    $this->data[$offset]['amount'],
                    new Currency((string)$this->data[$offset]['currency'])
                );
            case 'type':
                return TransactionType::from(str_replace('_transaction', '', $this->data[$offset]));
            case 'cardId':
                return Uuid::fromString($this->data['card']['id']);
            case 'cardNumber':
                return $this->data['card']['number'];
            default:
                return parent::__get($offset);
        }

    }
}