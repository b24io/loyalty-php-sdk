<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Cards;

use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Common\Result\Cards\CardsResult;
use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Services\AbstractService;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Component\Uid\Uuid;

class Cards extends AbstractService
{
    public function getById(Uuid $id): CardItemResult
    {
        return new CardItemResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    sprintf('cards/%s', $id->toRfc4122()),
                )
            )->getResponseData()->result
        );
    }

    public function list(?int $page = 1): CardsResult
    {
        return new CardsResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    'cards',
                    [],
                    $page
                )
            )
        );
    }

    /**
     * @throws BaseException
     */
    public function count(): int
    {
        return (int)(new CardsResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    'cards',
                    [],
                    1
                )
            )
        ))->getCoreResponse()->getResponseData()->pagination->total;
    }
}