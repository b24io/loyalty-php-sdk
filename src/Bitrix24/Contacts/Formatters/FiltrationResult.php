<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters;

use B24io\Loyalty\SDK\Bitrix24\Contacts;
use B24io\Loyalty\SDK\Cards;

/**
 * Class FiltrationResult
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Formatters
 */
class FiltrationResult
{
    /**
     * @param Contacts\DTO\FiltrationResult $filtrationResult
     *
     * @return array
     */
    public static function toArray(Contacts\DTO\FiltrationResult $filtrationResult): array
    {
        return [
            'card'    => $filtrationResult->getCard() !== null ? Cards\Formatters\Card::toArray(
                $filtrationResult->getCard()
            ) : null,
            'contact' => $filtrationResult->getContact() !== null ? Contacts\Formatters\Contact::toArray(
                $filtrationResult->getContact()
            ) : null,
        ];
    }
}