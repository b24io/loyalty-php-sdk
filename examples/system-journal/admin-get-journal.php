<?php

declare(strict_types=1);
require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

use \Monolog\Logger;
use \B24io\Loyalty\SDK;
use \B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use Ramsey\Uuid\Uuid;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

$argv = getopt('', ['clientApiKey::', 'authApiKey::', 'apiEndpoint::', 'dateFrom::', 'dateTo::']);
$fileName = basename(__FILE__);


$clientApiKey = $argv['clientApiKey'];
if ($clientApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «clientApiKey» not found') . PHP_EOL);
}
$authApiKey = $argv['authApiKey'];
if ($authApiKey === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «authApiKey»  not found') . PHP_EOL);
}
$apiEndpoint = $argv['apiEndpoint'];
if ($apiEndpoint === null) {
    throw new \InvalidArgumentException(sprintf('error: argument «apiEndpoint»  not found') . PHP_EOL);
}
$dateFrom = new \DateTime($argv['dateFrom']);
$dateTo = new \DateTime($argv['dateTo']);

// check connection to API
$log = new Logger('loyalty-php-sdk');
$log->pushHandler(new \Monolog\Handler\StreamHandler('loyalty-php-sdk-example.log', Logger::DEBUG));
$guzzleHandlerStack = HandlerStack::create();
$guzzleHandlerStack->push(Middleware::log($log, new MessageFormatter(MessageFormatter::SHORT)));
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
$systemJournalTransport = SDK\SystemJournal\Transport\Admin\Fabric::getSystemJournalTransport($apiClient, $log);

try {
    $result = $settingsTransport->getApplicationSettings();
    print(sprintf('currency form application settings: %s' . PHP_EOL, $result->getSettings()->getCurrency()->getCode()));

    $journalResponse = $systemJournalTransport->getSystemJournalByPeriod($dateFrom, $dateTo, null);

    print (sprintf('system journal response: ' . PHP_EOL));
    print (sprintf('- date from: %s' . PHP_EOL, $journalResponse->getSystemJournal()->getDateFrom()->format(\DATE_ATOM)));
    print (sprintf('- date to: %s' . PHP_EOL, $journalResponse->getSystemJournal()->getDateTo()->format(\DATE_ATOM)));
    print (sprintf('- count: %s' . PHP_EOL, $journalResponse->getSystemJournal()->getItems()->count()));

    foreach ($journalResponse->getSystemJournal()->getItems() as $cnt => $journalItem) {
        print(sprintf(
                '%s | %s | %s | %s | %s |',
                $cnt,
                $journalItem->getTimestamp()->format(\DATE_ATOM),
                $journalItem->getLevel()->key(),
                $journalItem->getSource(),
                $journalItem->getMessage()
            ) . PHP_EOL);
    }
} catch (\Throwable $exception) {
    var_dump($exception->getMessage());
}