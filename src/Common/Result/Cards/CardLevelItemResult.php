<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Result\Cards;

use B24io\Loyalty\SDK\Core\Result\AbstractItem;
use DateTimeImmutable;
use Exception;
use MoneyPHP\Percentage\Percentage;
use Symfony\Component\Uid\Uuid;

/**
 * @property-read Uuid $id
 * @property-read ?Uuid $nextLevelId
 * @property-read string $name
 * @property-read string $code
 * @property-read Percentage $defaultPercentage
 * @property-read string $description
 * @property-read string $externalId
 * @property-read DateTimeImmutable $created
 * @property-read DateTimeImmutable $modified
 */
class CardLevelItemResult extends AbstractItem
{
    /**
     * @param int|string $offset
     * @throws Exception
     */
    public function __get($offset)
    {
        switch ($offset) {
            case 'nextLevelId':
                if ($this->data['next_level_id'] === null) {
                    return null;
                }
                return Uuid::fromString($this->data['next_level_id']);
            case 'defaultPercentage':
                return new Percentage($this->data['default_percentage']);
            default:
                return parent::__get($offset);
        }
    }
}