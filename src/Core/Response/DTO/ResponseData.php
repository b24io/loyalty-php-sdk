<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response\DTO;

class ResponseData
{
    /**
     * @readonly
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