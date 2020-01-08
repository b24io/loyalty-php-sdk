<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\Formatters;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Bitrix24\Contacts;
use B24io\Loyalty\SDK\Transport;

/**
 * Class ContactResponse
 *
 * @package B24io\Loyalty\SDK\Transactions\Transport\Formatters
 */
class FiltrationResultResponse
{
    /**
     * @param Contacts\Transport\DTO\FiltrationResultResponse $filtrationResultResponse
     *
     * @return array
     */
    public static function toArray(Contacts\Transport\DTO\FiltrationResultResponse $filtrationResultResponse): array
    {
        $items = [];
        foreach ($filtrationResultResponse->getFiltrationResultCollection() as $item) {
            $items[] = Contacts\Formatters\FiltrationResult::toArray($item);
        }

        return [
            'meta'   => Transport\Formatters\Metadata::toArray($filtrationResultResponse->getMeta()),
            'result' => $items,
        ];
    }
}