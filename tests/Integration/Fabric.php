<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration;

use B24io\Loyalty\SDK\Core\ApiClient;
use B24io\Loyalty\SDK\Core\Core;
use B24io\Loyalty\SDK\Core\Contracts\ApiClientInterface;
use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use B24io\Loyalty\SDK\Core\Credentials\Credentials;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Uid\Uuid;

class Fabric
{
    public static function getLogger(): LoggerInterface
    {
        $log = new Logger('integration-test');
        $log->pushHandler(new StreamHandler(STDOUT, (int)$_ENV['INTEGRATION_TEST_LOG_LEVEL']));
        $log->pushProcessor(new MemoryUsageProcessor(true, true));
        $log->pushProcessor(new IntrospectionProcessor());

        return $log;
    }

    public static function getApiClient(): ApiClientInterface
    {
        return new ApiClient(
            new Credentials(
                $_ENV['LOYALTY_API_ENDPOINT_URL'],
                Uuid::fromString($_ENV['LOYALTY_API_CLIENT_ID']),
                $_ENV['LOYALTY_API_ADMIN_KEY'] !== null ?
                    Uuid::fromString($_ENV['LOYALTY_API_ADMIN_KEY']) : null
            ),
            HttpClient::create(
                [
                    'http_version' => '2.0',
                    'timeout' => 20,
                ]
            ),
            self::getLogger()
        );
    }

    public static function getCore(): CoreInterface
    {
        return new Core(
            self::getApiClient(),
            self::getLogger()
        );
    }

    public static function getAdminServiceBuilder(): AdminServiceBuilder
    {
        return new AdminServiceBuilder(
            self::getCore(),
            self::getLogger()
        );
    }
}