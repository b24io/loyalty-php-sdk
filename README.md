# loyalty-php-sdk

[![License](https://poser.pugx.org/b24io/loyalty-php-sdk/license.svg)](https://packagist.org/packages/b24io/loyalty-php-sdk) [![Total Downloads](https://poser.pugx.org/b24io/loyalty-php-sdk/downloads.svg)](https://packagist.org/packages/b24io/loyalty-php-sdk) [![Build Status](https://travis-ci.org/b24io/loyalty-php-sdk.svg?branch=master)](https://travis-ci.org/b24io/loyalty-php-sdk)

Loyalty PHP SDK is a tool for work with REST-API Bitrix24
Application [Loyalty Program and bonus cards for Bitrix24 CRM](https://www.bitrix24.ru/apps/?app=b24io.loyalty)

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

* `admin` - can work with all cards in his account and loyalty application instance
* `user` - can work only with his own card

We work with many accounts, each account has a `CLIENT_API_KEY`
If you want work in admin role you must use `ADMIN_API_KEY` to sign queries.
If you want work with client role in JS you must use `CLIENT_API_KEY` and `CARD_UUID` as user API key.

## Domain entities available from REST-API

Legend

* ✅ — available wia rest-api and implemented in PHP-SDK
* 🛠 — available wia rest-api and **not** implemented in PHP-SDK
* ❌ — not implemented in rest-api

### Cards

Work with card as an `admin` role

| Method          | Status | Description                        |
|-----------------|--------|------------------------------------|
| `list`          | ✅      | get card list with page navigation |
| `getById`       | ✅      | get card by uuid                   |
| `count`         | ✅️     | count cards                        |
| `delete`        | 🛠️    | delete card by uuid                |
| `add`           | ❌️     | add new card                       |
| `block`         | ❌️     | block card by uuid                 |
| `unblock`       | ❌️     | unblock card by uuid               |
| `setLevel`      | ❌️     | set card level by uuid             |
| `setPercentage` | ❌️     | set card percentage by uuid        |

Work with card as a `user` role

| Method    | Status | Description      |
|-----------|--------|------------------|
| `getById` | 🛠     | get card by uuid |

### CardLevels

Work with card levels as an `admin` role

| Method   | Status | Description         |
|----------|--------|---------------------|
| `list`   | 🛠     | get card level list |
| `add`    | 🛠     | add new card level  |
| `delete` | 🛠     | delete card level   |
| `update` | ❌️     | update card level   |

### Transactions

Work with transactions as an `admin` role.

Transactions service contains this methods, list method work with pagination

| Method                                  | Description                                         |
|-----------------------------------------|-----------------------------------------------------|
| `list`                                  | get transactions list for all cards with pagination |
| `count`                                 | count transactions                                  |
| `getByCardNumber`                       | get transactions list for current card number       |
| `processAccrualTransactionByCardNumber` | process accrual transaction                         |
| `processPaymentTransactionByCardNumber` | process payment transaction                         |

if you want read all transactions without pagination you can work with `TransactionsFetcher`All fetcher methods return generator, under the hood fetcher use pagination. 

| Method               | Description                                                                                     |
|----------------------|-------------------------------------------------------------------------------------------------|
| `list`               | get transactions list for all cards  |
| `listByCardNumber`   | list all transactions for current card                                                          |


Work with transactions as an `user` role

| Method        | Status | Description                            |
|---------------|--------|----------------------------------------|
| `getByCardId` | 🛠     | get transactions list for current card |

### Contacts

Work with contacts as an `admin` role

| Method             | Status | Description                 |
|--------------------|--------|-----------------------------|
| `list`             | ✅      | get contacts list           |
| `getById`          | ✅      | get contact by id           |
| `add`              | ✅      | add new contact             |
| `update`           | ❌️     | update contact              |
| `count`            | 🛠     | count contacts              |
| `startAuthByPhone` | ❌️     | start auth attempt by phone |
| `finishAuth`       | ❌️     | finish auth attempt         |


Work with contacts as an `user` role

| Method             | Status | Description                 |
|--------------------|--------|-----------------------------|
| `getById`          | 🛠     | get contact by id           |
| `startAuthByPhone` | 🛠     | start auth attempt by phone |
| `finishAuth`       | 🛠     | finish auth attempt         |


### Company

Work with company as an `admin` role

| Method    | Status | Description         |
|-----------|--------|---------------------|
| `current` | ❌      | get current company |
| `add`     | ❌️     | add company         |
| `update`  | ❌️     | update company      |
| `delete`  | ❌️     | delete company      |

Work with company as an `user` role

| Method    | Status | Description         |
|-----------|--------|---------------------|
| `current` | 🛠     | get current company |

### ApplicationJournal
Work with application journal as an `admin` role

| Method    | Status | Description                                             |
|-----------|--------|---------------------------------------------------------|
| `list`    | 🛠     | get application journal items list with page navigation |
| `getById` | 🛠     | get application journal item by id                      |


### TouchPoints
Work with touch points as an `admin` role

| Method    | Status | Description                                |
|-----------|--------|--------------------------------------------|
| `list`    | 🛠     | get touch points list with page navigation |
| `getById` | 🛠     | get touch point item by id                 |
| `add`     | 🛠     | add new touch point                        |
| `update`  | ❌️     | update touch point                         |
| `delete`  | 🛠️    | delete touch point                         |


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
