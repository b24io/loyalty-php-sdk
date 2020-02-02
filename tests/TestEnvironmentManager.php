<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests;

use \Monolog\Logger;
use \Monolog\Processor\IntrospectionProcessor;
use \Monolog\Processor\MemoryPeakUsageProcessor;
use \Monolog\Processor\MemoryUsageProcessor;
use \Monolog\Processor\UidProcessor;

use \B24io\Loyalty\SDK;
use \GuzzleHttp\HandlerStack;
use \GuzzleHttp\Middleware;
use \GuzzleHttp\MessageFormatter;
use Psr\Log\LoggerInterface;
use \Ramsey\Uuid\Uuid;

/**
 * Class TestEnvironmentManager
 *
 * @package B24io\Loyalty\SDK\Tests
 */
class TestEnvironmentManager
{
    /**
     * @return LoggerInterface
     * @throws \Exception
     */
    public static function getApiClientLogger(): LoggerInterface
    {
        $log = new Logger('b24.loyalty');
        $log->pushProcessor(new MemoryUsageProcessor());
        $log->pushProcessor(new MemoryUsageProcessor);
        $log->pushProcessor(new MemoryPeakUsageProcessor);
        $log->pushProcessor(new IntrospectionProcessor);
        $log->pushProcessor(new UidProcessor());
        $log->pushHandler(
            new \Monolog\Handler\StreamHandler(__DIR__ . '/logs/' . getenv('LOYALTY_API_CLIENT_LOG_FILE'), Logger::DEBUG)
        );
        $log->pushHandler(new \Monolog\Handler\StreamHandler('php://stdout', Logger::WARNING));

        return $log;
    }

    /**
     * @return SDK\ApiClient
     * @throws \Exception
     */
    public static function getPhpSdkApiClientForRoleAdmin(): SDK\ApiClient
    {
        $guzzleHandlerStack = HandlerStack::create();
        $guzzleHandlerStack->push(
            Middleware::log(
                self::getApiClientLogger(),
                new MessageFormatter(MessageFormatter::SHORT)
            )
        );
        $httpClient = new \GuzzleHttp\Client();
        $token = new SDK\Auth\DTO\Token(
            SDK\Transport\DTO\Role::initializeByCode('admin'),
            Uuid::fromString(getenv('LOYALTY_PRODUCTION_TEST_CLIENT_API_KEY')),
            Uuid::fromString(getenv('LOYALTY_PRODUCTION_TEST_CLIENT_ADMIN_KEY'))
        );
        $apiClient = new SDK\ApiClient(getenv('LOYALTY_PRODUCTION_TEST_API_ENDPOINT'), $token, $httpClient, self::getApiClientLogger());
        $apiClient->setGuzzleHandlerStack($guzzleHandlerStack);

        return $apiClient;
    }
}