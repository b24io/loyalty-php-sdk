<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO\Statuses;

/**
 * Interface StatusInterface
 *
 * @package B24io\Loyalty\SDK\Cards\DTO\Statuses
 */
interface StatusInterface
{
    /**
     * @return string
     */
    public function getCode(): string;
}