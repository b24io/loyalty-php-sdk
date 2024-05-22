<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Contacts;

use B24io\Loyalty\SDK\Common\FullName;
use B24io\Loyalty\SDK\Common\Gender;
use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Common\Result\Cards\CardLevelItemResult;
use B24io\Loyalty\SDK\Common\Result\Turnovers\TurnoversItemResult;
use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use DateTimeImmutable;
use DateTimeZone;
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
 * @property-read ?CardLevelItemResult $cardLevel
 * @property-read ?TurnoversItemResult $turnovers
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
                if ($this->data[$offset] === null) {
                    return null;
                }
                return new DateTimeImmutable($this->data[$offset]);
            case 'gender':
                return Gender::from($this->data[$offset]);
            case 'externalIds':
                return $this->data['external_ids'];
            case 'card':
                if ($this->data['card'] === null) {
                    return null;
                }
                return new CardItemResult($this->data['card']);
            case 'cardLevel':
                if ($this->data['card_level'] === null) {
                    return null;
                }
                return new CardLevelItemResult($this->data['card_level']);
            case 'turnovers':
                if ($this->data['turnovers'] === null) {
                    return null;
                }
                return new TurnoversItemResult($this->data['turnovers']);
            default:
                return parent::__get($offset);
        }
    }
}