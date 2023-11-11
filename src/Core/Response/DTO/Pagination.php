<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response\DTO;

readonly class Pagination
{
    public function __construct(
        public ?int $count,
        public ?int $total,
        public ?int $page,
        public ?int $pages,
        public ?int $pageSize,
    )
    {
    }
    public static function initFromArray(array $pagination): self
    {
        return new self(
            $pagination['count'],
            $pagination['total'],
            $pagination['page'],
            $pagination['pages'],
            $pagination['per_page'],
        );
    }
}