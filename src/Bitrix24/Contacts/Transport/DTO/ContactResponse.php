<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Transport\DTO;

use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Contact;
use B24io\Loyalty\SDK\Cards\DTO\Card;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class ContactResponse
 *
 * @package B24io\Loyalty\SDK\Transactions\Transport\DTO
 */
class ContactResponse
{
    /**
     * @var Metadata
     */
    private $meta;
    /**
     * @var Contact|null
     */
    private $contact;
    /**
     * @var Card|null
     */
    private $card;

    /**
     * ContactResponse constructor.
     *
     * @param Metadata     $meta
     * @param Contact|null $contact
     * @param Card|null    $card
     */
    public function __construct(Metadata $meta, ?Contact $contact, ?Card $card)
    {
        $this->meta = $meta;
        $this->contact = $contact;
        $this->card = $card;
    }

    /**
     * @return Metadata
     */
    public function getMeta(): Metadata
    {
        return $this->meta;
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