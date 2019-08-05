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
class ContactResponse
{
    /**
     * @param Contacts\Transport\DTO\ContactResponse $contactResponse
     *
     * @return array
     */
    public static function toArray(Contacts\Transport\DTO\ContactResponse $contactResponse): array
    {
        return [
            'meta' => Transport\Formatters\Metadata::toArray($contactResponse->getMeta()),
            'result' => [
                'card' => $contactResponse->getCard() !== null ? Cards\Formatters\Card::toArray($contactResponse->getCard()) : null,
                'contact' => $contactResponse->getContact() !== null ? Contacts\Formatters\Contact::toArray($contactResponse->getContact()) : null,
            ],
        ];
    }
}