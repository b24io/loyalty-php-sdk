# loyalty-php-sdk
## 1.1.0 (26.01.2020)
* add method `getReportByMetricCode` in `\Metrics\Transport\Admin` transport, return `MetricReportResponse` with `Report` DTO
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
* add method `filterContactsByEmail` in `\Bitrix24\Contacts\Transport\Admin` transport, return FiltrationResult with two items: CardDTO and ContactDTO  
* add method `filterContactsByPhone` in `\Bitrix24\Contacts\Transport\Admin` transport, return FiltrationResult with two items: CardDTO and ContactDTO
* add method `getByCardUuid` in `\Bitrix24\Contacts\Transport\Admin` transport, return ContactResponse with two items: CardDTO and ContactDTO
* add method `getByCardUuid` in `\Bitrix24\Contacts\Transport\User` transport, return ContactResponse with two items: CardDTO and ContactDTO
* add method `getCardByUuid` in `\Cards\Transport\Admin` transport, return CardDTO or throw exception `CardNotFound`
* add method `getCardByUuid` in `\Cards\Transport\User` transport, return CardDTO or throw exception `CardNotFound`
* add method `getOperationsByPeriod` in `\OperationsJournal\Transport\Admin` transport, return `OperationsJournalResponse`
* add method `getOperationsByPeriod` in `\OperationsJournal\Transport\User` transport, return `OperationsJournalResponse`
* add MetricDTO and transport 
* change mobile phone data structure in Contact DTO in JSON API response
* change mobile phone in ContactDTO can be nullable
* change `authKey` and `clientKey` in `TokenDTO` string values to `UuidInterface` 
* remove `countryRegionCode` argument in methods `add` and `addWithCardNumber` in `\Bitrix24\Contacts\Transport\Admin` transport
* remove setters in CardDTO object
 
## 0.1.3 (6.08.2019)
* fix contact formatter error

## 0.1.2 (5.08.2019)
* add transport `Bitrix24\Contacts\Transport\Admin`

## 0.1.1 (18.01.2019)
* add transport `Settings`

## 0.1.0 (2.01.2019)
* initial version