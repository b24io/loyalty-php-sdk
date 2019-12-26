<?php

declare(strict_types=1);
require_once 'vendor/autoload.php';

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

$bitrix24Transport = SDK\Bitrix24\Contacts\Transport\Admin\Fabric::getTransactionsTransport($apiClient, $log);
$result = $bitrix24Transport->filterContactsByEmail(new SDK\Users\DTO\Email('test1@gmail.com'));

print(sprintf('query result:') . PHP_EOL);
print(sprintf(' - message operation: %s', $result->getMeta()->getMessage()) . PHP_EOL);
print(sprintf(' - role: %s', $result->getMeta()->getRole()->getCode()) . PHP_EOL);
print(sprintf(' - duration: %s', $result->getMeta()->getDuration()) . PHP_EOL);
print(sprintf('items count: %s', $result->getFiltrationResultCollection()->count()) . PHP_EOL);

print(sprintf('filtration result items:') . PHP_EOL);
$phoneNumberFormatter = \libphonenumber\PhoneNumberUtil::getInstance();
foreach ($result->getFiltrationResultCollection() as $item) {
    print('========' . PHP_EOL);
    if ($item->getContact() !== null) {
        print(sprintf('- contact:') . PHP_EOL);
        print(sprintf('  id: %s', $item->getContact()->getContactId()->getId()) . PHP_EOL);
        print(sprintf('  email: %s', $item->getContact()->getEmail()) . PHP_EOL);
        print(sprintf(
                '  phone: %s',
                $item->getContact()->getMobilePhone() !== null ?
                    $phoneNumberFormatter->format(
                        $item->getContact()->getMobilePhone(),
                        \libphonenumber\PhoneNumberFormat::INTERNATIONAL
                    ) : null
            ) . PHP_EOL);
    }
    if ($item->getCard() !== null) {
        $decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());
        print(sprintf('- card:') . PHP_EOL);
        print(sprintf('  number: %s', $item->getCard()->getNumber()) . PHP_EOL);
        print(sprintf('  uuid: %s', $item->getCard()->getUuid()->toString()) . PHP_EOL);
        print(sprintf('  status: %s', $item->getCard()->getStatus()->getCode()) . PHP_EOL);
        print(sprintf(
            '  balance: %s %s',
            $decimalMoneyFormatter->format($item->getCard()->getBalance()),
            $item->getCard()->getBalance()->getCurrency()->getCode() . PHP_EOL
        ));
    }
}