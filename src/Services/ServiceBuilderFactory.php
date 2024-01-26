<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services;

use B24io\Loyalty\SDK\Core\ApiClient;
use B24io\Loyalty\SDK\Core\Contracts\ApiClientInterface;
use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use B24io\Loyalty\SDK\Core\Core;
use B24io\Loyalty\SDK\Core\Credentials\Credentials;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Uid\Uuid;

readonly class ServiceBuilderFactory
{
    public static function createAdminRoleServiceBuilder(
        LoggerInterface $logger,
        string          $apiEndpointUrl,
        string          $apiClientId,
        string          $apiAdminKey
    ): AdminServiceBuilder
    {
        return new AdminServiceBuilder(
            self::getCore(
                $logger,
                $apiEndpointUrl,
                $apiClientId,
                $apiAdminKey
            ),
            $logger
        );
    }

    private static function getCore(LoggerInterface $logger,
                                    string          $apiEndpointUrl,
                                    string          $apiClientId,
                                    ?string         $apiAdminKey = null): CoreInterface
    {
        return new Core(
            self::getApiClient(
                $logger,
                $apiEndpointUrl,
                $apiClientId,
                $apiAdminKey
            ),
            $logger
        );
    }

    private static function getApiClient(
        LoggerInterface $logger,
        string          $apiEndpointUrl,
        string          $apiClientId,
        ?string         $apiAdminKey = null
    ): ApiClientInterface
    {
        return new ApiClient(
            new Credentials(
                $apiEndpointUrl,
                Uuid::fromString($apiClientId),
                $apiAdminKey !== null ?
                    Uuid::fromString($apiAdminKey) : null
            ),
            HttpClient::create(
                [
                    'http_version' => '2.0',
                    'timeout' => 60,
                ]
            ),
            $logger
        );
    }
}