# loyalty-php-sdk
Loyalty PHP SDK is a tool for work with REST-API Bitrix24 Application [Loyalty Program and bonus cards for Bitrix24 CRM](https://www.bitrix24.ru/apps/?app=b24io.loyalty)

* Loyalty app adds bonus card for Bitrix24 client profile in CRM
* Loyalty app support transactions for payment and accrual operations
* store percentage of discount
* operations with cards: create, read, delete, block
 
## Who uses loyalty PHP SDK
* B2C companies who works with customers and grow they LTV
* HoReCa companies such us fast food or restaurants

## How it works
<p align="center">
  <img src="./docs/img/loyalty-php-sdk-base-schema.jpg" alt="Loyalty Program and bonus cards for Bitrix24 CRM" width="1333">
</p>

## Domain entities
In loyalty-php-sdk available domain entities from application with DTO (data transfer objects).  

### Cards
Loyalty card object:
* `number` - card number
* `barcode` - card barcode
* `status` - card status enumeration (active, blocked or deleted)
* `user` - card owner user id 
* `balance` - card balance with php-money object
* `percentage` - card percentage
* `created` - card date create
* `modified` - card date modified
* `uuid` - card [universally unique identifier](https://en.wikipedia.org/wiki/Universally_unique_identifier)

### Transactions
Transactions - accrual or payment operation with card balance
Transaction object:
* `value` - transaction amount with php-money object
* `operationId` - internal operation id, read only
* `type` - payment or accrual transaction
* `cardNumber` - card number
* `created` - transaction date create
* `reason` - transaction reason with comment  

### Turnovers

### OperationsJournal

### Metrics

### Bitrix24 Contacts

## Installation

### Requirements
Loyalty PHP SDK works with PHP 7.1 or above, need ext-json and ext-curl support

## Basic Usage
```php
use \Monolog\Logger;
use \B24io\Loyalty\SDK;
use Ramsey\Uuid\Uuid;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\MessageFormatter;

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
    Uuid::fromString('CLIENT_API_KEY'),
    Uuid::fromString('ADMIN_API_KEY')
);
$apiClient = new SDK\ApiClient($apiEndpoint, $token, $httpClient, $log);
$apiClient->setGuzzleHandlerStack($guzzleHandlerStack);

$cardsTransport = SDK\Cards\Transport\Admin\Fabric::getCardTransport($apiClient, $log);

$cardResponse = $cardsTransport->getCardByNumber(22222);

$decimalMoneyFormatter = new \Money\Formatter\DecimalMoneyFormatter(new \Money\Currencies\ISOCurrencies());
var_dump($cardResponse->getCard()->getNumber());
var_dump($cardResponse->getCard()->getStatus()->getCode());
var_dump($decimalMoneyFormatter->format($cardResponse->getCard()->getBalance()));
var_dump($cardResponse->getCard()->getPercentage()->format());
```
### admin and user mode

## Documentation

## Submitting bugs and feature requests

## License