<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Requests;

class ItemsOrder
{
    /**
     * @readonly
     */
    public ?string $orderBy = null;
    /**
     * @readonly
     */
    public OrderDirection $direction;

    /**
     * @param string|null $orderBy
     * @param OrderDirection|null $direction
     */
    public function __construct(
        ?string         $orderBy = null,
        ?OrderDirection $direction = null)
    {
        $this->orderBy = $orderBy;
        if ($direction === null) {
            $direction = OrderDirection::desc();
        }
        $this->direction = $direction;
    }

    public function toQueryParams(): string
    {
        return http_build_query([
            'orderBy' => $this->orderBy,
            'orderDirection' => (string)$this->direction,
        ]);
    }
}