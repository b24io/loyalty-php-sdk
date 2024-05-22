<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response\DTO;

class Pagination
{
    /**
     * @readonly
     */
    public ?int $count;
    /**
     * @readonly
     */
    public ?int $total;
    /**
     * @readonly
     */
    public ?int $page;
    /**
     * @readonly
     */
    public ?int $pages;
    /**
     * @readonly
     */
    public ?int $pageSize;
    public function __construct(?int $count, ?int $total, ?int $page, ?int $pages, ?int $pageSize)
    {
        $this->count = $count;
        $this->total = $total;
        $this->page = $page;
        $this->pages = $pages;
        $this->pageSize = $pageSize;
    }
    /**
     * @param array<string,?int> $pagination
     * @return self
     */
    public static function initFromArray(array $pagination): self
    {
        return new self(
            $pagination['count'] ?? null,
            $pagination['total'] ?? null,
            $pagination['page'] ?? null,
            $pagination['pages'] ?? null,
            $pagination['per_page'] ?? null,
        );
    }
}