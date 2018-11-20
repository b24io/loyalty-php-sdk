<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class Metadata
 *
 * @package B24io\Loyalty\SDK\Transport\Formatters
 */
class Metadata
{
    /**
     * @param SDK\Transport\DTO\Metadata $metadata
     *
     * @return array
     */
    public static function toArray(SDK\Transport\DTO\Metadata $metadata): array
    {
        return [
            'duration' => $metadata->getDuration(),
            'message' => $metadata->getMessage(),
            'role' => $metadata->getRole()->getCode(),
        ];
    }
}