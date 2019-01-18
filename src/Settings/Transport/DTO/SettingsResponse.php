<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Settings\Transport\DTO;

use B24io\Loyalty\SDK\Settings\DTO\Settings;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class SettingsResponse
 *
 * @package B24io\Loyalty\SDK\Settings\Transport\DTO
 */
class SettingsResponse
{
    /**
     * @var Metadata
     */
    private $meta;
    /**
     * @var Settings
     */
    private $settings;

    /**
     * SettingsResponse constructor.
     *
     * @param Metadata $meta
     * @param Settings $settings
     */
    public function __construct(Metadata $meta, Settings $settings)
    {
        $this->meta = $meta;
        $this->settings = $settings;
    }

    /**
     * @return Metadata
     */
    public function getMeta(): Metadata
    {
        return $this->meta;
    }

    /**
     * @return Settings
     */
    public function getSettings(): Settings
    {
        return $this->settings;
    }
}