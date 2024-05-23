<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services;

use B24io\Loyalty\SDK\Core\ApiClient;
use B24io\Loyalty\SDK\Core\Contracts\ApiClientInterface;
use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use B24io\Loyalty\SDK\Core\Core;
use B24io\Loyalty\SDK\Core\Credentials\Credentials;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ServiceBuilderFactory
{
    public static function createAdminRoleServiceBuilder(string               $apiEndpointUrl, string               $apiClientId, string               $apiAdminKey, LoggerInterface      $logger, ?HttpClientInterface $httpClient = null): AdminServiceBuilder
    {
        return new AdminServiceBuilder(
            self::getCore(
                $logger,
                $apiEndpointUrl,
                $apiClientId,
                $apiAdminKey,
                $httpClient
            ),
            $logger
        );
    }

    private static function getCore(
        LoggerInterface      $logger,
        string               $apiEndpointUrl,
        string               $apiClientId,
        ?string              $apiAdminKey = null,
        ?HttpClientInterface $httpClient = null
    ): CoreInterface
    {
        return new Core(
            self::getApiClient(
                $logger,
                $apiEndpointUrl,
                $apiClientId,
                $apiAdminKey,
                $httpClient
            ),
            $logger
        );
    }

    private static function getApiClient(
        LoggerInterface      $logger,
        string               $apiEndpointUrl,
        string               $apiClientId,
        ?string              $apiAdminKey = null,
        ?HttpClientInterface $httpClient = null
    ): ApiClientInterface
    {
        return new ApiClient(
            new Credentials(
                $apiEndpointUrl,
                Uuid::fromString($apiClientId),
                $apiAdminKey !== null ?
                    Uuid::fromString($apiAdminKey) : null
            ),
            $httpClient ?? self::getDefaultHttpClient(),
            $logger
        );
    }

    public static function getDefaultHttpClient(): HttpClientInterface
    {
        return new CurlHttpClient(
            [
                'http_version' => '2.0',
                'timeout' => 60,
            ],
        );
    }
}