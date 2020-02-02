<?php

declare(strict_types=1);
require_once 'vendor/autoload.php';

use \Monolog\Logger;
use \B24io\Loyalty\SDK;
use \B24io\Loyalty\SDK\OperationsJournal\DTO\OperationType;
use Ramsey\Uuid\Uuid;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

$argv = getopt('', ['clientApiKey::', 'authApiKey::', 'apiEndpoint::']);
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

$bitrix24Transport = SDK\Bitrix24\Contacts\Transport\Admin\Fabric::getBitrix24ContactsTransport($apiClient, $log);

try {
    $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
    $randomMobileNumber = $phoneUtil->parse(
        sprintf(
            '+7%s',
            substr(str_replace('.', '', (string)microtime(true)), 0, 10)
        )
    );
    $randomCardNumber = (int)str_replace('.', '', (string)microtime(true));

    $contactDto = new SDK\Bitrix24\Contacts\DTO\Contact(
        new \DateTime(),
        new \DateTime(),
        'John',
        'Doe',
        null,
        $randomMobileNumber
    );

    $result = $bitrix24Transport->addWithCardNumber($contactDto, $randomCardNumber, new SDK\Transport\DTO\Reason('examples'));
    print(sprintf('query result:') . PHP_EOL);
    print(sprintf(' - message operation: %s', $result->getMeta()->getMessage()) . PHP_EOL);
    print(sprintf(' - role: %s', $result->getMeta()->getRole()->key()) . PHP_EOL);
    print(sprintf(' - duration: %s', $result->getMeta()->getDuration()) . PHP_EOL);

    $phoneNumberFormatter = \libphonenumber\PhoneNumberUtil::getInstance();
    print(sprintf('- contact:') . PHP_EOL);
    print(sprintf('  id: %s', $result->getContact()->getContactId()->getId()) . PHP_EOL);
    print(sprintf('  email: %s', $result->getContact()->getEmail()) . PHP_EOL);
    print(sprintf(
            '  phone: %s',
            $result->getContact()->getMobilePhone() !== null ?
                $phoneNumberFormatter->format(
                    $result->getContact()->getMobilePhone(),
                    \libphonenumber\PhoneNumberFormat::INTERNATIONAL
                ) : null
        ) . PHP_EOL);

    $decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());
    print(sprintf('- card:') . PHP_EOL);
    print(sprintf('  number: %s', $result->getCard()->getNumber()) . PHP_EOL);
    print(sprintf('  uuid: %s', $result->getCard()->getUuid()->toString()) . PHP_EOL);
    print(sprintf('  status: %s', $result->getCard()->getStatus()->getCode()) . PHP_EOL);
    print(sprintf(
        '  balance: %s %s',
        $decimalMoneyFormatter->format($result->getCard()->getBalance()),
        $result->getCard()->getBalance()->getCurrency()->getCode() . PHP_EOL
    ));
    print(sprintf('  percentage: %s', $result->getCard()->getPercentage()->format()) . PHP_EOL);
} catch (SDK\Exceptions\ApiClientException $exception) {
    var_dump($exception->getApiProblem()->asArray());
} catch (\Throwable $exception) {
    var_dump($exception->getMessage());
}