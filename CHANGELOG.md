# loyalty-php-sdk
## 0.2.0 (28.12.2019)
* add OperationsJournal
* add operation type `AccrualTransaction`
* add operation type `PaymentTransaction`
* add field `OperationUuid` in Operation entity
* add field `CardUuid` in Card entity
* add method `filterContactsByEmail` in `\Bitrix24\Contacts\Transport\Admin` transport, return FiltrationResult with two items: CardDTO and ContactDTO  
* add method `filterContactsByPhone` in `\Bitrix24\Contacts\Transport\Admin` transport, return FiltrationResult with two items: CardDTO and ContactDTO  
* change mobile phone data structure in Contact DTO in JSON API response
* change mobile phone in ContactDTO can be nullable 
* remove `countryRegionCode` argument in methods `add` and `addWithCardNumber` in `\Bitrix24\Contacts\Transport\Admin` transport
 
## 0.1.3 (6.08.2019)
* fix contact formatter error

## 0.1.2 (5.08.2019)
* add transport `Bitrix24\Contacts\Transport\Admin`

## 0.1.1 (18.01.2019)
* add transport `Settings`

## 0.1.0 (2.01.2019)
* initial version