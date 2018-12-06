<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\Transport\DTO;

use B24io\Loyalty\SDK\Transport\DTO\Metadata;
use B24io\Loyalty\SDK\Turnover\DTO\Turnover;

/**
 * Class TurnoverResponse
 *
 * @package B24io\Loyalty\SDK\Turnover\Transport\DTO
 */
class TurnoverResponse
{
    /**
     * @var Metadata
     */
    private $meta;
    /**
     * @var Turnover
     */
    private $turnover;

    /**
     * TurnoverResponse constructor.
     *
     * @param Metadata $meta
     * @param Turnover $turnover
     */
    public function __construct(Metadata $meta, Turnover $turnover)
    {
        $this->meta = $meta;
        $this->turnover = $turnover;
    }

    /**
     * @return Metadata
     */
    public function getMeta(): Metadata
    {
        return $this->meta;
    }

    /**
     * @return Turnover
     */
    public function getTurnover(): Turnover
    {
        return $this->turnover;
    }
}