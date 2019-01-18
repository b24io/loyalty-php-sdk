<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Settings\DTO;

use Money\Currency;

/**
 * Class Settings
 *
 * @package B24io\Loyalty\SDK\Settings\DTO
 */
class Settings
{
    /**
     * @var Currency
     */
    private $currency;

    /**
     * @return Currency
     */
    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    /**
     * @param Currency $currency
     *
     * @return Settings
     */
    public function setCurrency(Currency $currency): Settings
    {
        $this->currency = $currency;

        return $this;
    }
}