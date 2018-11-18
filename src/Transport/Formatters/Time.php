<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class Time
 *
 * @package B24io\Loyalty\SDK\Transport\Formatters
 */
class Time
{
    /**
     * @param SDK\Transport\DTO\Time $time
     *
     * @return array
     */
    public static function toArray(SDK\Transport\DTO\Time $time): array
    {
        return [
            'duration' => $time->getDuration(),
            'date_start' => $time->getDateStart()->format(\DATE_ATOM),
            'date_end' => $time->getDateEnd()->format(\DATE_ATOM),
        ];
    }
}