<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Settings\DTO;

use B24io\Loyalty\SDK\Cards;
use B24io\Loyalty\SDK\Users;
use Money\Currency;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Settings\DTO
 */
class Fabric
{
    /**
     * @param array $settings
     *
     * @return Settings
     */
    public static function initSettingsFromArray(array $settings): Settings
    {
        $newSettings = new Settings();
        $newSettings
            ->setCurrency(new Currency($settings['currency']['application_currency_code']));

        return $newSettings;
    }
}