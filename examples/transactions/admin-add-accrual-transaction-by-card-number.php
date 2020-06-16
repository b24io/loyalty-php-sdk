<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use B24io\Loyalty\SDK;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Logger;
use Ramsey\Uuid\Uuid;

$argv = getopt('', ['clientApiKey::', 'authApiKey::', 'apiEndpoint::', 'cardNumber::', 'amount::']);
$fileName = basename(__FILE__);

$clientApiKey = $argv['clientApiKey'];
if ($clientApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «clientApiKey»  not found%s', PHP_EOL));
}
$authApiKey = $argv['authApiKey'];
if ($authApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «authApiKey»  not found%s', PHP_EOL));
}
$apiEndpoint = $argv['apiEndpoint'];
if ($apiEndpoint === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «apiEndpoint»  not found%s', PHP_EOL));
}
$cardNumber = $argv['cardNumber'];
if ($cardNumber === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «cardNumber»  not found%s', PHP_EOL));
}
$amount = $argv['amount'];
if ($amount === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «amount»  not found%s', PHP_EOL));
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
$token = new SDK\Auth\DTO\Token(
    SDK\Transport\DTO\Role::initializeByCode('admin'),
    Uuid::fromString($clientApiKey),
    Uuid::fromString($authApiKey)
);
$apiClient = new SDK\ApiClient($apiEndpoint, $token, $httpClient, $log);
$apiClient->setGuzzleHandlerStack($guzzleHandlerStack);

// connect to application and read settings
$settingsTransport = SDK\Settings\Transport\Admin\Fabric::getSettingsTransport($apiClient, $log);

$currency = $settingsTransport->getApplicationSettings()->getSettings()->getCurrency();
$transactionsTransport = SDK\Transactions\Transport\Admin\Fabric::getTransactionsTransport($apiClient, $log);

try {
    $trxResult = $transactionsTransport->processAccrualTransactionByCardNumber(
        (int)$cardNumber,
        new SDK\Transport\DTO\Reason('test trx'),
        new \Money\Money($amount, $currency)
    );

    $decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());

    print(sprintf('transaction result: ') . PHP_EOL);
    print(sprintf('  operationId: %s', $trxResult->getTransaction()->getOperationId()->getId()) . PHP_EOL);
    print(sprintf('  card.number: %s', $trxResult->getTransaction()->getCardNumber()) . PHP_EOL);
    print(sprintf('  type: %s', $trxResult->getTransaction()->getType()) . PHP_EOL);
    print(sprintf('  reason.code: %s', $trxResult->getTransaction()->getReason()->getCode()) . PHP_EOL);
    print(sprintf(
            '  amount: %s %s',
            $decimalMoneyFormatter->format($trxResult->getTransaction()->getValue()),
            $trxResult->getTransaction()->getValue()->getCurrency()->getCode()
        ) . PHP_EOL);
} catch (\Throwable $exception) {
    print(sprintf('ошибка: %s', $exception->getMessage()));
}
