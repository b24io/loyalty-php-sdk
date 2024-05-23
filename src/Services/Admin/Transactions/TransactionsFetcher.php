<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions;

use B24io\Loyalty\SDK\Common\Result\Transactions\TransactionItemResult;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use Generator;
use Psr\Log\LoggerInterface;

class TransactionsFetcher
{
    /**
     * @readonly
     */
    private Transactions $transactions;
    /**
     * @readonly
     */
    private LoggerInterface $logger;
    public function __construct(Transactions    $transactions, LoggerInterface $logger)
    {
        $this->transactions = $transactions;
        $this->logger = $logger;
    }

    /**
     * @return Generator<TransactionItemResult>
     * @throws BaseException
     */
    public function list(): Generator
    {
        $res = $this->transactions->list();

        $pages = $res->getCoreResponse()->getResponseData()->pagination->pages;
        $this->logger->debug('TransactionsFetcher.list.start', [
            'total' => $res->getCoreResponse()->getResponseData()->pagination->total,
            'pages' => $pages
        ]);

        $trxCnt = 0;
        for ($i = 1; $i <= $pages; $i++) {
            $res = $this->transactions->list($i);
            $this->logger->debug('TransactionsFetcher.list.pageItem', [
                'page' => $res->getCoreResponse()->getResponseData()->pagination->page,
                'trxCnt' => $trxCnt
            ]);

            foreach ($res->getTransactions() as $trx) {
                $trxCnt++;
                yield $trxCnt => $trx;
            }

        }
        $this->logger->debug('TransactionsFetcher.list.finish');
    }

    /**
     * @return Generator<TransactionItemResult>
     * @throws BaseException
     */
    public function listByCardNumber(string $cardNumber): Generator
    {
        $firstPage = $this->transactions->getByCardNumber($cardNumber);
        $trxCnt = 0;
        foreach ($firstPage->getTransactions() as $trx) {
            $trxCnt++;
            yield $trxCnt => $trx;
        }

        $pagesCnt = $firstPage->getCoreResponse()->getResponseData()->pagination->pages;
        if ($pagesCnt > 1) {
            for ($page = 2; $page <= $pagesCnt; $page++) {
                $res = $this->transactions->getByCardNumber($cardNumber, $page);
                foreach ($res->getTransactions() as $trx) {
                    $trxCnt++;
                    yield $trxCnt => $trx;
                }
            }
        }
    }
}