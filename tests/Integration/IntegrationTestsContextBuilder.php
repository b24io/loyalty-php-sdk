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
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\TraceableHttpClient;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class IntegrationTestsContextBuilder
{
    public static function getCredentials(): Credentials
    {
        return new Credentials(
            $_ENV['LOYALTY_API_ENDPOINT_URL'],
            Uuid::fromString($_ENV['LOYALTY_API_CLIENT_ID']),
            $_ENV['LOYALTY_API_ADMIN_KEY'] !== null ? Uuid::fromString($_ENV['LOYALTY_API_ADMIN_KEY']) : null
        );
    }

    public static function getDefaultLogger(): LoggerInterface
    {
        $log = new Logger('loyalty-php-sdk-integration-test');
        $log->pushHandler(new StreamHandler($_ENV['INTEGRATION_TEST_LOG_FILE'], (int)$_ENV['INTEGRATION_TEST_LOG_LEVEL']));
        $log->pushProcessor(new MemoryUsageProcessor(true, true));
        $log->pushProcessor(new IntrospectionProcessor());

        return $log;
    }

    public static function getDefaultHttpClient(): HttpClientInterface
    {
        return HttpClient::create();
    }

    public static function getTraceableHttpClient(): HttpClientInterface
    {
        $client = new TraceableHttpClient(
            new CurlHttpClient(
                [
                    'http_version' => '2.0',
                    'timeout' => 30,
                ]
            ),
            new Stopwatch(true)
        );
        $client->setLogger(self::getDefaultLogger());
        return $client;
    }

    public static function getApiClient(): ApiClientInterface
    {
        return new ApiClient(self::getCredentials(), self::getDefaultHttpClient(), self::getDefaultLogger());
    }

    public static function getCore(): CoreInterface
    {
        return new Core(
            self::getApiClient(),
            self::getDefaultLogger()
        );
    }

    public static function getAdminServiceBuilder(): AdminServiceBuilder
    {
        return new AdminServiceBuilder(
            self::getCore(),
            self::getDefaultLogger()
        );
    }
}