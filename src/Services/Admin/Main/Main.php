<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Main;

use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Response\Response;
use B24io\Loyalty\SDK\Services\AbstractService;
use Fig\Http\Message\RequestMethodInterface;


class Main extends AbstractService
{
    public function health(): Response
    {
        return $this->core->call(new Command(
            Context::admin(),
            RequestMethodInterface::METHOD_GET,
            'health',
        ));
    }
}