<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\Transport\DTO;

use B24io\Loyalty\SDK\Cards\DTO\Card;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class CardResponse
 *
 * @package B24io\Loyalty\SDK\Cards\Transport\DTO
 */
class CardResponse
{
    /**
     * @var Metadata
     */
    private $meta;
    /**
     * @var Card
     */
    private $card;

    /**
     * CardResponse constructor.
     *
     * @param Card     $card
     * @param Metadata $meta
     */
    public function __construct(Card $card, Metadata $meta)
    {
        $this->card = $card;
        $this->meta = $meta;
    }

    /**
     * @return Metadata
     */
    public function getMeta(): Metadata
    {
        return $this->meta;
    }

    /**
     * @return Card
     */
    public function getCard(): Card
    {
        return $this->card;
    }
}