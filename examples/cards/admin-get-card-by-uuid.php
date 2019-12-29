<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use \Monolog\Logger;
use \B24io\Loyalty\SDK;
use \B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

$argv = getopt('', ['clientApiKey::', 'authApiKey::', 'apiEndpoint::', 'uuid::']);
$fileName = basename(__FILE__);

$clientApiKey = $argv['clientApiKey'];
if ($clientApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «clientApiKey»  not found') . PHP_EOL);
}
$authApiKey = $argv['authApiKey'];
if ($authApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «authApiKey»  not found') . PHP_EOL);
}
$apiEndpoint = $argv['apiEndpoint'];
if ($apiEndpoint === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «apiEndpoint»  not found') . PHP_EOL);
}

$rawUuid = $argv['uuid'];
if ($apiEndpoint === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «uuid»  not found') . PHP_EOL);
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

try {
    $cardResponse = $cardsTransport->getCardByUuid(\Ramsey\Uuid\Uuid::fromString($rawUuid));

    $decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());
    print(sprintf('- card:') . PHP_EOL);
    print(sprintf('  number: %s', $cardResponse->getCard()->getNumber()) . PHP_EOL);
    print(sprintf('  uuid: %s', $cardResponse->getCard()->getUuid()->toString()) . PHP_EOL);
    print(sprintf('  status: %s', $cardResponse->getCard()->getStatus()->getCode()) . PHP_EOL);

    print(sprintf(
        '  balance: %s %s',
        $decimalMoneyFormatter->format($cardResponse->getCard()->getBalance()),
        $cardResponse->getCard()->getBalance()->getCurrency()->getCode() . PHP_EOL
    ));
    print(sprintf('  percentage: %s', $cardResponse->getCard()->getPercentage()->format()) . PHP_EOL);
} catch (SDK\Exceptions\ApiClientException $exception) {
    var_dump($exception->getApiProblem()->asArray());
}