<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class Problem
 *
 * @package B24io\Loyalty\SDK\Transport\Formatters
 */
class Problem
{
    /**
     * @param SDK\Transport\DTO\Problem $problem
     *
     * @return array
     */
    public static function toArray(SDK\Transport\DTO\Problem $problem): array
    {
        return [
            'type' => $problem->getType(),
            'title' => $problem->getTitle(),
            'status' => $problem->getStatus(),
            'detail' => $problem->getDetail(),
            'instance' => $problem->getInstance(),
        ];
    }
}