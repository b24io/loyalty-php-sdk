<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

use B24io\Loyalty\SDK\Cards\DTO\Card;

/**
 * Class FiltrationResult
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class FiltrationResult
{
    /**
     * @var Contact|null
     */
    private $contact;
    /**
     * @var Card|null
     */
    private $card;

    /**
     * FiltrationResult constructor.
     *
     * @param Contact|null $contact
     * @param Card|null    $card
     */
    public function __construct(?Contact $contact, ?Card $card)
    {
        $this->contact = $contact;
        $this->card = $card;
    }

    /**
     * @return Contact|null
     */
    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    /**
     * @return Card|null
     */
    public function getCard(): ?Card
    {
        return $this->card;
    }
}