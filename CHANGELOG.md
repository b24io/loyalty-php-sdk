# loyalty-php-sdk

## 4.1.0 (2024.05.22)
* add `TurnoversItemResult` for `CardItemResult`, contains:
  * total purchases count
  * total purchases sum
* add `TurnoversItemResult` for `ContactItemResult`, contains:
  * total purchases count
  * total purchases sum
* add `CardLevelItem` for `ContactItemResult`, contains:
  * `id` card level id  
  * `nextLevelId` next level id
  * `name` level name
  * `code` level code
  * `defaultPercentage` card level default percentage
  * `description` card level description
  * `externalId` card level external id
  * `created` date time card level create
  * `modified` date time card level update

## 4.0.0 (2024.05.11)
* bump SDK version for PHP `8.2` and `8.3` branch


## 3.1.0 (2024.05.11)

* add requirements:
    * `symfony/console` version `7.*`,
    * `symfony/dotenv`: version `7.*`,
* add `InvalidArgumentException` class
* add `ItemsOrder` for `Command` class
* add `Cards::add` method for add cards, you can set start params for card:
    * card start balance
    * card start percentage
    * card start status: active or blocked
* add order by argument for entities:
    * `cards` - order available by fields
        * `created`
        * `modified`
        * `balance`
    * `contacts`
        * `created`
        * `modified`
* add `ItemsOrder` for `Cards\Fetcher` class
* add `Contacts::count` for count contacts
* add `ContactsFetcher` for bulk read contacts

## 3.0 (2024.01.15)

* migrate to 'symfony/http-client'
* bump minimum PHP version requirements to `8.3.*`
* add `TransactionsFetcher` - fetch transactions
* add cli command `transactions:burn-bonuses`
* add `TransactionsReader` - read transactions from csv-file

## 2.1.2 (01.06.2022)

* bump `guzzlehttp/guzzle` version requirements to `6.*`

## 2.1.1 (10.01.2022)

* bump `ramsey/uuid` version requirements to `4.*`

## 2.1.0 (7.12.2021)

* bump php version requirements to `7.4` or `8.*`

## 2.0.1 (1.10.2020)

* add support for rps-error limits - no more than 2 rps
* update dependencies
* add x-request-id header support

## 2.0.0 (1.02.2020)

* add unit tests for `\SDK\Bitrix24\Contacts\DTO\Fabric::initContactFromArray`
* add example `admin-add-contact-with-card-number.php`
* add integration tests for `\SDK\Bitrix24\Contacts\Transport\Admin\Transport`
* change constructor args for `\SDK\Bitrix24\Contacts\DTO\Contact`
* remove setters for `\SDK\Bitrix24\Contacts\DTO\Contact`
* remove setters for `\SDK\Bitrix24\Contacts\DTO\Address`

## 1.1.0 (26.01.2020)

* add method `getReportByMetricCode` in `\Metrics\Transport\Admin` transport, return `MetricReportResponse`
  with `Report` DTO
* add interface `DefaultRequestArgumentsInterface` with default request argument fields
* add SystemJournal transport for role admin

## 1.0.0 (8.01.2020)

* add OperationsJournal
* add operation type `AccrualTransaction`
* add operation type `PaymentTransaction`
* add operation type `BlockCard`
* add operation type `CreateCard`
* add operation type `DeleteCard`
* add operation type `UnblockCard`
* add operation type `IncrementPercentage`
* add operation type `DecrementPercentage`
* add operation type `Purchase`
* add operation type `DealMonetaryDiscount` for Bitrix24 deal
* add operation type `DealPercentageDiscount` for Bitrix24 deal
* add field `OperationUuid` in Operation entity
* add field `CardUuid` in Card entity
* add method `filterContactsByEmail` in `\Bitrix24\Contacts\Transport\Admin` transport, return FiltrationResult with two
  items: CardDTO and ContactDTO
* add method `filterContactsByPhone` in `\Bitrix24\Contacts\Transport\Admin` transport, return FiltrationResult with two
  items: CardDTO and ContactDTO
* add method `getByCardUuid` in `\Bitrix24\Contacts\Transport\Admin` transport, return ContactResponse with two items:
  CardDTO and ContactDTO
* add method `getByCardUuid` in `\Bitrix24\Contacts\Transport\User` transport, return ContactResponse with two items:
  CardDTO and ContactDTO
* add method `getCardByUuid` in `\Cards\Transport\Admin` transport, return CardDTO or throw exception `CardNotFound`
* add method `getCardByUuid` in `\Cards\Transport\User` transport, return CardDTO or throw exception `CardNotFound`
* add method `getOperationsByPeriod` in `\OperationsJournal\Transport\Admin` transport,
  return `OperationsJournalResponse`
* add method `getOperationsByPeriod` in `\OperationsJournal\Transport\User` transport,
  return `OperationsJournalResponse`
* add MetricDTO and transport
* change mobile phone data structure in Contact DTO in JSON API response
* change mobile phone in ContactDTO can be nullable
* change `authKey` and `clientKey` in `TokenDTO` string values to `UuidInterface`
* remove `countryRegionCode` argument in methods `add` and `addWithCardNumber` in `\Bitrix24\Contacts\Transport\Admin`
  transport
* remove setters in CardDTO object

## 0.1.3 (6.08.2019)

* fix contact formatter error

## 0.1.2 (5.08.2019)

* add transport `Bitrix24\Contacts\Transport\Admin`

## 0.1.1 (18.01.2019)

* add transport `Settings`

## 0.1.0 (2.01.2019)

* initial version
