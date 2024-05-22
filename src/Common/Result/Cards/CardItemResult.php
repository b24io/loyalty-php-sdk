<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Cards;

use B24io\Loyalty\SDK\Common\Result\Contacts\ContactItemResult;
use B24io\Loyalty\SDK\Common\Result\Turnovers\TurnoversItemResult;
use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use DateTimeImmutable;
use Money\Currency;
use Money\Money;
use MoneyPHP\Percentage\Percentage;
use Symfony\Component\Uid\Uuid;

/**
 * @property-read Uuid $id
 * @property-read string $number
 * @property-read string $barcode
 * @property-read Money $balance
 * @property-read Percentage $percentage
 * @property-read DateTimeImmutable $created
 * @property-read DateTimeImmutable $modified
 * @property-read CardStatus $status
 * @property-read string $externalId
 * @property-read ?CardLevelItemResult $level
 * @property-read ContactItemResult $contact
 * @property-read TurnoversItemResult $turnovers
 */
class CardItemResult extends AbstractItem
{
    public function __get(int|string $offset)
    {
        switch ($offset) {
            case 'number':
                return (string)$this->data[$offset];
            case 'balance':
                return $this->decimalMoneyParser->parse(
                    $this->data[$offset]['amount'],
                    new Currency($this->data[$offset]['currency'] ?? '')
                );
            case 'percentage':
                return new Percentage($this->data[$offset]);
            case 'status':
                return CardStatus::from($this->data[$offset]);
            case 'level':
                if ($this->data['card_level'] === null) {
                    return null;
                }
                return new CardLevelItemResult($this->data['card_level']);
            case 'contact':
                if ($this->data[$offset] === null) {
                    return null;
                }
                return new ContactItemResult($this->data[$offset]);
            case 'turnovers':
                if ($this->data[$offset] === null) {
                    return null;
                }
                return new TurnoversItemResult($this->data[$offset]);
            default:
                return parent::__get($offset);
        }
    }
}