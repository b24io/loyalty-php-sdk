<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Formatters\Cards;

use B24io\Loyalty\SDK\Common\Result\Cards\CardLevelItemResult;

/**
 * @readonly
 */
class CardLevelItemFormatter
{
    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'card_level_id',
            'card_level_next_level_id',
            'card_level_name',
            'card_level_code',
            'card_level_default_percentage',
            'card_level_description',
            'card_level_external_id',
            'card_level_created',
            'card_level_modified'
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function toFlatArray(?CardLevelItemResult $level): array
    {
        if ($level === null) {
            return [
                'card_level_id' => null,
                'card_level_next_level_id' => null,
                'card_level_name' => null,
                'card_level_code' => null,
                'card_level_default_percentage' => null,
                'card_level_description' => null,
                'card_level_external_id' => null,
                'card_level_created' => null,
                'card_level_modified' => null,
            ];
        }

        return [
            'card_level_id' => $level->id->toRfc4122(),
            'card_level_next_level_id' => $level->nextLevelId!==null? $level->nextLevelId->toRfc4122() : null,
            'card_level_name' => $level->name,
            'card_level_code' => $level->code,
            'card_level_default_percentage' =>$level->defaultPercentage->format(),
            'card_level_description' => $level->description,
            'card_level_external_id' => $level->externalId,
            'card_level_created' => $level->created->format(DATE_ATOM),
            'card_level_modified' => $level->modified->format(DATE_ATOM),
        ];
    }
}