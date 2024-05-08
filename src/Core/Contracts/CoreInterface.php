<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Contracts;

use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Response\Response;

interface CoreInterface
{
    public function call(Command $cmd): Response;
}