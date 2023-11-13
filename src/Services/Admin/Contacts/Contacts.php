<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Contacts;

use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Response\Response;
use B24io\Loyalty\SDK\Services\AbstractService;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardItemResult;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardsResult;
use B24io\Loyalty\SDK\Services\Admin\Contacts\Result\ContactItemResult;
use B24io\Loyalty\SDK\Services\Admin\Contacts\Result\ContactsResult;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\Uid\Uuid;


class Contacts extends AbstractService
{
    public function getById(Uuid $id): ContactItemResult
    {
        return new ContactItemResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    sprintf('contacts/%s', $id->toRfc4122()),
                )
            )->getResponseData()->result
        );
    }

    public function list(?ContactsFilter $filter = null, ?int $page = 1): ContactsResult
    {
        $url = 'contacts';
        if (!is_null($filter)) {
            $url .= $filter->build();
        }

        return new ContactsResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    $url,
                    [],
                    $page
                )
            )
        );
    }
}