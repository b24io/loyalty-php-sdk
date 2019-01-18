<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Settings\Formatters;

use B24io\Loyalty;

/**
 * Class Settings
 *
 * @package B24io\Loyalty\SDK\Settings\Formatters
 */
class Settings
{
    /**
     * @param Loyalty\SDK\Settings\DTO\Settings $settings
     *
     * @return array
     */
    public static function toArray(Loyalty\SDK\Settings\DTO\Settings $settings): array
    {
        return [
            'currency' => [
                'application_currency_code' => $settings->getCurrency()->getCode(),
            ],
        ];
    }
}