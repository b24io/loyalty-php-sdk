<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Transactions;

use B24io\Loyalty\SDK\Common\Reason;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Tests\Integration\Fabric;
use Money\Currency;
use Money\Money;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TransactionsTest extends TestCase
{
    protected AdminServiceBuilder $sb;

    /**
     * @throws TransportExceptionInterface
     */
    public function testTransactionsList(): void
    {
        $res = $this->sb->getTransactions()->list();
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testTransactionsListByCardNumber(): void
    {
        $res = $this->sb->getTransactions()->getByCardNumber('1');
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
    }

    public function testProcessAccrualTransactionByCardNumber(): void
    {
        $res = $this->sb->getTransactions()->processAccrualTransactionByCardNumber(
            '1',
            new Money('10000', new Currency('RUB')),
            new Reason('1', 'test', 'test')
        );

        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
    }

    public function setUp(): void
    {
        $this->sb = Fabric::getAdminServiceBuilder();
    }
}