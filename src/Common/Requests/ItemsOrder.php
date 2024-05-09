<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Requests;

use B24io\Loyalty\SDK\Core\Exceptions\InvalidArgumentException;

class ItemsOrder
{
    /**
     * @var string|null
     * @readonly
     */
    public ?string $orderBy;
    /**
     * @var string
     * @readonly
     */
    public string $direction;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(string $orderBy = null, string $direction = 'desc')
    {
        if (!in_array($direction, ['asc', 'desc'], true)) {
            throw new InvalidArgumentException(sprintf('you must use direction «asc» or «desc», wrong direction key «%s»', $direction));
        }
        $this->orderBy = $orderBy;
        $this->direction = $direction;
    }

    public function toQueryParams(): string
    {
        return http_build_query([
            'orderBy' => $this->orderBy,
            'orderDirection' => $this->direction,
        ]);
    }
}