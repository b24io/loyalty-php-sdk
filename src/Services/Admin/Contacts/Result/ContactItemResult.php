<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Contacts\Result;

use B24io\Loyalty\SDK\Common\FullName;
use B24io\Loyalty\SDK\Common\Gender;
use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use B24io\Loyalty\SDK\Services\Admin\Cards\CardStatus;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardItemResult;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Money\Money;
use Money\Currency;
use Symfony\Component\Uid\Uuid;

/**
 * @property-read Uuid $id
 * @property-read FullName $fullName
 * @property-read DateTimeZone $timezone
 * @property-read ?DateTimeImmutable $birthday
 * @property-read Gender $gender
 * @property-read array $externalIds
 * @property-read DateTimeImmutable $created
 * @property-read DateTimeImmutable $modified
 * @property-read ?CardItemResult $card
 */
class ContactItemResult extends AbstractItem
{
    public function __get(int|string $offset)
    {
        switch ($offset) {
            case 'fullName':
                return new FullName(
                    (string)$this->data['full_name']['name'],
                    (string)$this->data['full_name']['surname'],
                    (string)$this->data['full_name']['patronymic']
                );
            case 'timezone':
                return new DateTimeZone($this->data[$offset]['name']);
            case 'birthday':
                return new DateTimeImmutable($this->data[$offset]) ?? null;
            case 'gender':
                return Gender::from($this->data[$offset]);
            case 'externalIds':
                return $this->data['external_ids'];
            case 'card':
                if ($this->data['card'] === null) {
                    return null;
                }
                return new CardItemResult($this->data['card']);
            default:
                return parent::__get($offset);
        }
    }
}