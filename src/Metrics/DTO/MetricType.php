<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class MetricType
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO
 * @method INTEGER()
 * @method FLOAT()
 * @method MONEY()
 * @method PERCENTAGE()
 */
final class MetricType extends AbstractEnumeration
{
    public const INTEGER = 'INTEGER';
    public const FLOAT = 'FLOAT';
    public const MONEY = 'MONEY';
    public const PERCENTAGE = 'PERCENTAGE';
}