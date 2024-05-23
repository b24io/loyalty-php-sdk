<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response\DTO;

class ResponseData
{
    /**
     * @readonly
     * @var array<string,mixed> $result
     */
    public array $result;
    /**
     * @readonly
     */
    public Metadata $metadata;
    /**
     * @readonly
     */
    public Pagination $pagination;

    /**
     * @param array<string,mixed> $result
     * @param Metadata $metadata
     * @param Pagination $pagination
     */
    public function __construct(
        array      $result,
        Metadata   $metadata,
        Pagination $pagination)
    {
        $this->result = $result;
        $this->metadata = $metadata;
        $this->pagination = $pagination;
    }
}