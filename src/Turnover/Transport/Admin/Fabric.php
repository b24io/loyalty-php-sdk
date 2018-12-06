<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Turnover\Transport\Admin;

use B24io\Loyalty\SDK\ApiClient;
use Psr\Log\LoggerInterface;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Turnover\Transport\Admin
 */
class Fabric
{
    /**
     * @param ApiClient       $apiClient
     * @param LoggerInterface $logger
     *
     * @return Transport
     */
    public static function getCardTransport(ApiClient $apiClient, LoggerInterface $logger): Transport
    {
        return new Transport($apiClient, $logger);
    }
}