<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Cards;

use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use Generator;
use Psr\Log\LoggerInterface;

class CardsFetcher
{
    public function __construct(
        private Cards           $cards,
        private LoggerInterface $logger
    )
    {
    }

    /**
     * @return Generator<CardItemResult>
     * @throws BaseException
     */
    public function list(): Generator
    {
        $res = $this->cards->list();

        $pages = $res->getCoreResponse()->getResponseData()->pagination->pages;
        $this->logger->debug('CardsFetcher.list.start', [
            'total' => $res->getCoreResponse()->getResponseData()->pagination->total,
            'pages' => $pages
        ]);

        $cardCnt = 0;
        for ($i = 1; $i <= $pages; $i++) {
            $res = $this->cards->list($i);
            $this->logger->info('CardsFetcher.list.pageItem', [
                'page' => $res->getCoreResponse()->getResponseData()->pagination->page,
                'cardCnt' => $cardCnt,
                'queryDuration' => $res->getCoreResponse()->getResponseData()->metadata->duration
            ]);

            foreach ($res->getCards() as $card) {
                $cardCnt++;
                yield $cardCnt => $card;
            }
        }
        $this->logger->debug('CardsFetcher.list.finish');
    }
}