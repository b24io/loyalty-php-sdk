<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response\DTO;

readonly class ResponseData
{
    public function __construct(
        /**
         * @var array<string, mixed>
         */
        public array      $result,
        public Metadata   $metadata,
        public Pagination $pagination)
    {
    }
}