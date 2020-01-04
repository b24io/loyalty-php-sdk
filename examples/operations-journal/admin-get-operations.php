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
$operationsTransport = SDK\OperationsJournal\Transport\Admin\Fabric::getTransactionsTransport($apiClient, $log);

$decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());

try {
    $result = $settingsTransport->getApplicationSettings();
    print(sprintf('currency form application settings: %s' . PHP_EOL, $result->getSettings()->getCurrency()->getCode()));

    $operationsResponse = $operationsTransport->getOperationsByPeriod($dateFrom, $dateTo);

    print (sprintf('operations journal response: ' . PHP_EOL));
    print (sprintf('- date from: %s' . PHP_EOL, $operationsResponse->getOperationsJournal()->getDateFrom()->format(\DATE_ATOM)));
    print (sprintf('- date to: %s' . PHP_EOL, $operationsResponse->getOperationsJournal()->getDateTo()->format(\DATE_ATOM)));
    print (sprintf('- count: %s' . PHP_EOL, $operationsResponse->getOperationsJournal()->getOperations()->count()));

    $decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());
    foreach ($operationsResponse->getOperationsJournal()->getOperations() as $cnt => $op) {
        switch ($op->getOperationType()) {
            case OperationType::ACCRUAL_TRANSACTION():
            case OperationType::PAYMENT_TRANSACTION():
                /**
                 * @var SDK\Transactions\DTO\TransactionInterface $op
                 */
                print(sprintf(
                    '%s | %s | user - %s |card uuid - %s | %s %s --- %s' . PHP_EOL,
                    $cnt,
                    $op->getOperationType()->key(),
                    $op->getUserId()->getId(),
                    $op->getCardUuid()->toString(),
                    $decimalMoneyFormatter->format($op->getValue()),
                    $op->getValue()->getCurrency()->getCode(),
                    $op->getReason()->getComment()
                ));
                break;
            case OperationType::PURCHASE():
                /**
                 * @var SDK\OperationsJournal\DTO\Purchases\Purchase $op
                 */
                print(sprintf(
                    '%s | %s | user - %s |card uuid - %s | purchase id - %s | %s' . PHP_EOL,
                    $cnt,
                    $op->getOperationType()->key(),
                    $op->getUserId()->getId(),
                    $op->getCardUuid()->toString(),
                    $op->getPurchaseId()->getId(),
                    $op->getReason()->getComment()
                ));
                break;
            default:
                print(sprintf(
                    '%s | %s | user - %s |card uuid - %s | %s' . PHP_EOL,
                    $cnt,
                    $op->getOperationType()->key(),
                    $op->getUserId()->getId(),
                    $op->getCardUuid()->toString(),
                    $op->getReason()->getComment()
                ));
                break;
        }
    }
} catch (\Throwable $exception) {
    var_dump($exception->getMessage());
}