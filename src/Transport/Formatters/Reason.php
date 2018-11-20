<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class Reason
 *
 * @package B24io\Loyalty\SDK\Transport\Formatters
 */
class Reason
{
    /**
     * @param SDK\Transport\DTO\Reason $reason
     *
     * @return array
     */
    public static function toArray(SDK\Transport\DTO\Reason $reason): array
    {
        return [
            'code' => $reason->getCode(),
            'comment' => $reason->getComment(),
            'id' => $reason->getId()
        ];
    }
}