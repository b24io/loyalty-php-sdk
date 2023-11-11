<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core;

use B24io\Loyalty\SDK\Core\Credentials\Context;

readonly class Command
{
    public function __construct(
        public Context $context,
        public string  $httpMethod,
        public string  $apiMethod,
        public array   $parameters = [],
        public ?int    $page = null)
    {
    }
}