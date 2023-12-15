<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Transactions;

use B24io\Loyalty\SDK\Common\Result\Transactions\TransactionItemResult;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use Generator;
use Psr\Log\LoggerInterface;

readonly class TransactionsFetcher
{
    public function __construct(
        private Transactions    $transactions,
        private LoggerInterface $logger
    )
    {
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

        $cardCnt = 0;
        for ($i = 1; $i <= $pages; $i++) {
            $res = $this->transactions->list($i);
            $this->logger->debug('TransactionsFetcher.list.pageItem', [
                'page' => $res->getCoreResponse()->getResponseData()->pagination->page,
                'cardCnt' => $cardCnt
            ]);

            foreach ($res->getTransactions() as $trx) {
                $cardCnt++;
                yield $cardCnt => $trx;
            }

        }
        $this->logger->debug('TransactionsFetcher.list.finish');
    }
}