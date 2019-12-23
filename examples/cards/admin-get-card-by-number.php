<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use \Monolog\Logger;
use \B24io\Loyalty\SDK;
use \B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

$argv = getopt('', ['clientApiKey::', 'authApiKey::', 'apiEndpoint::']);
$fileName = basename(__FILE__);
$example = '';

$clientApiKey = $argv['clientApiKey'];
if ($clientApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «clientApiKey»  not found, example:%s%s', PHP_EOL, $example));
}
$authApiKey = $argv['authApiKey'];
if ($authApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «authApiKey»  not found, example:%s%s', PHP_EOL, $example));
}
$apiEndpoint = $argv['apiEndpoint'];
if ($apiEndpoint === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «apiEndpoint»  not found, example:%s%s', PHP_EOL, $example));
}

// check connection to API
$log = new Logger('loyalty-php-sdk');
$log->pushHandler(new \Monolog\Handler\StreamHandler('loyalty-php-sdk-example.log', Logger::DEBUG));
$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(
    Middleware::log(
        $log,
        new MessageFormatter(MessageFormatter::SHORT)
    )
);
$httpClient = new \GuzzleHttp\Client();

$log->info('loyalty.apiClient.start');
$token = new SDK\Auth\DTO\Token(SDK\Transport\DTO\Role::initializeByCode('admin'), $clientApiKey, $authApiKey);
$apiClient = new SDK\ApiClient($apiEndpoint, $token, $httpClient, $log);
$apiClient->setGuzzleHandlerStack($guzzleHandlerStack);

// connect to application and read settings
$settingsTransport = SDK\Settings\Transport\Admin\Fabric::getSettingsTransport($apiClient, $log);
$cardsTransport = SDK\Cards\Transport\Admin\Fabric::getCardTransport($apiClient, $log);

$cardResponse = $cardsTransport->getCardByNumber(22222);

$decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());
var_dump($cardResponse->getCard()->getNumber());
var_dump($cardResponse->getCard()->getStatus()->getCode());
var_dump($decimalMoneyFormatter->format($cardResponse->getCard()->getBalance()));
var_dump($cardResponse->getCard()->getPercentage()->format());
exit();

