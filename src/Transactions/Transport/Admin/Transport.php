<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Transport\Admin;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Cards;

use Fig\Http\Message\RequestMethodInterface;
use Money\Money;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Transactions\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @param int                      $cardNumber
     * @param SDK\Transport\DTO\Reason $reason
     * @param Money                    $amount
     *
     * @return SDK\Transactions\Transport\DTO\TransactionResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function processAccrualTransactionByCardNumber(int $cardNumber, SDK\Transport\DTO\Reason $reason, Money $amount): SDK\Transactions\Transport\DTO\TransactionResponse
    {
        $this->log->debug('b24io.loyalty.sdk.transactions.transport.admin.processAccrualTransaction.start', [
            'cardNumber' => $cardNumber,
        ]);

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/transactions/process-accrual',
            RequestMethodInterface::METHOD_POST,
            SDK\Transactions\Formatters\ProcessAccrualTransaction::toArray(
                SDK\Transactions\Operations\Fabric::createProcessAccrualTransaction($cardNumber, $amount, $reason))
        );

        $transactionResponse = new SDK\Transactions\Transport\DTO\TransactionResponse(
            $this->initMetadata($requestResult['meta']),
            SDK\Transactions\DTO\Fabric::initAccrualTransactionFromArray($requestResult['result'])
        );

        $this->log->debug('b24io.loyalty.sdk.transactions.transport.admin.processAccrualTransaction.finish', [
            'cardNumber' => $cardNumber,
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($transactionResponse->getMeta()),
        ]);

        return $transactionResponse;
    }
}