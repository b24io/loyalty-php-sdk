# loyalty-php-sdk 
[![License](https://poser.pugx.org/b24io/loyalty-php-sdk/license.svg)](https://packagist.org/packages/b24io/loyalty-php-sdk) [![Total Downloads](https://poser.pugx.org/b24io/loyalty-php-sdk/downloads.svg)](https://packagist.org/packages/b24io/loyalty-php-sdk) [![Build Status](https://travis-ci.org/b24io/loyalty-php-sdk.svg?branch=master)](https://travis-ci.org/b24io/loyalty-php-sdk)

Loyalty PHP SDK is a tool for work with REST-API Bitrix24 Application [Loyalty Program and bonus cards for Bitrix24 CRM](https://www.bitrix24.ru/apps/?app=b24io.loyalty)

* Loyalty app adds bonus card for Bitrix24 client profile in CRM
* Loyalty app support transactions for payment and accrual operations
* store percentage of discount
* operations with cards: create, read, delete, block

## Documentation
* [REST-API documentation](https://loyalty.b24.cloud/public/docs/api/v2/)

## Installation
Via Composer

```bash
$ composer require b24io/loyalty-php-sdk
```

### Requirements
Loyalty PHP SDK works with PHP 8.2 or above, need `ext-json` and `ext-curl` support

## Authentication with admin and user roles
SDK can work with two roles: 
* `admin` - can work with all cards in his Bitrix24 account and loyalty application instance 
* `user` - can work only with his card 

Bitrix24 Application Loyalty Program and bonus cards work with many Bitrix24 accounts, each account has a `CLIENT_API_KEY` 
If you want work in admin role you must use `ADMIN_API_KEY` to sign queries.
If you want work with client role in JS you must use `CLIENT_API_KEY` and `CARD_UUID` as user API key. 

## Basic Usage

## Command line utilities
Command line utilities for work via REST-API

```shell
php bin/console
```
- `cards:export` Export loyalty cards to csv file
- `transactions:bulk-transaction` Bulk transaction to all active cards: accrual or payment
- `transactions:load-from-file` Process transactions from csv file
- `transactions:export` Export transactions to csv file

## Submitting bugs and feature requests
Bugs and feature request are tracked on [GitHub](https://github.com/b24io/loyalty-php-sdk/issues)

## Support
* [app@b24.io](mailto:app@b24.io)  

## Security
If you discover any security related issues, please contact us at [app@b24.io](mailto:app@b24.io)

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
