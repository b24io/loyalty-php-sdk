<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

/**
 * Class AbstractResponse
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
abstract class AbstractResponse
{
    /**
     * @var Metadata
     */
    protected $meta;

    /**
     * AbstractResponse constructor.
     *
     * @param Metadata $meta
     */
    public function __construct(Metadata $meta)
    {
        $this->meta = $meta;
    }

    /**
     * @return Metadata
     */
    public function getMeta(): Metadata
    {
        return $this->meta;
    }
}