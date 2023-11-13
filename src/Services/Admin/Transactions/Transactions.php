<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Common\TransactionType;
use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Services\AbstractService;
use B24io\Loyalty\SDK\Services\Admin\Transactions\Result\ProcessedTransactionResult;
use B24io\Loyalty\SDK\Services\Admin\Transactions\Result\TransactionsResult;
use Fig\Http\Message\RequestMethodInterface;
use Money\Money;
use Symfony\Component\Uid\Uuid;

class Transactions extends AbstractService
{
    public function list(?int $page = 1): TransactionsResult
    {
        return new TransactionsResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    'transactions',
                    [],
                    $page
                )
            )
        );
    }

    public function getByCardNumber(string $cardNumber, ?int $page = 1): TransactionsResult
    {
        return new TransactionsResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    sprintf('transactions/with-card-number/%s', $cardNumber),
                    [],
                    $page
                )
            )
        );
    }

    public function processAccrualTransactionByCardNumber(string $cardNumber, Money $amount, Reason $reason): ProcessedTransactionResult
    {
        return new ProcessedTransactionResult($this->core->call(
            new Command(
                Context::admin,
                RequestMethodInterface::METHOD_POST,
                sprintf('transactions/with-card-number/%s', $cardNumber),
                [
                    'type' => TransactionType::accrual->name,
                    'bonus_points' => [
                        'amount' => $this->decimalMoneyFormatter->format($amount),
                        'currency' => $amount->getCurrency()->getCode(),
                    ],
                    'reason' => $reason->toArray(),
                ],
                null,
                Uuid::v4()
            )
        ));
    }
}