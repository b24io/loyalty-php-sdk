<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Requests;

readonly class ItemsOrder
{
    public function __construct(
        public ?string        $orderBy = null,
        public OrderDirection $direction = OrderDirection::desc)
    {
    }

    public function toQueryParams(): string
    {
        return http_build_query([
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->direction->value,
        ]);
    }
}