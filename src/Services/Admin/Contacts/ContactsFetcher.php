<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Contacts;

use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Common\Result\Contacts\ContactItemResult;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use Generator;
use Psr\Log\LoggerInterface;

readonly class ContactsFetcher
{
    public function __construct(
        private Contacts        $contacts,
        private LoggerInterface $logger
    )
    {
    }

    /**
     * @return Generator<ContactItemResult>
     * @throws BaseException
     */
    public function list(
        ?ContactsFilter $filter = null,
        ?ItemsOrder     $order = null,
    ): Generator
    {
        $res = $this->contacts->list($filter);

        $pages = $res->getCoreResponse()->getResponseData()->pagination->pages;
        $this->logger->debug('ContactsFetcher.list.start', [
            'total' => $res->getCoreResponse()->getResponseData()->pagination->total,
            'pages' => $pages
        ]);

        $contactCnt = 0;
        for ($i = 1; $i <= $pages; $i++) {
            $res = $this->contacts->list($filter, $order, $i);
            $this->logger->info('CardsFetcher.list.pageItem', [
                'page' => $res->getCoreResponse()->getResponseData()->pagination->page,
                'contactCnt' => $contactCnt,
                'queryDuration' => $res->getCoreResponse()->getResponseData()->metadata->duration
            ]);

            foreach ($res->getContacts() as $contact) {
                $contactCnt++;
                yield $contactCnt => $contact;
            }
        }
        $this->logger->debug('ContactsFetcher.list.finish');
    }
}