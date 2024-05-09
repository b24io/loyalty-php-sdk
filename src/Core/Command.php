<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core;

use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use Symfony\Component\Uid\Uuid;

readonly class Command
{
    /**
     * @param Context $context
     * @param string $httpMethod
     * @param string $apiMethod
     * @param array<string, mixed> $parameters
     * @param ItemsOrder|null $itemsOrder
     * @param int|null $page
     * @param Uuid|null $idempotencyKey
     */
    public function __construct(
        public Context     $context,
        public string      $httpMethod,
        public string      $apiMethod,
        public array       $parameters = [],
        public ?ItemsOrder $itemsOrder = null,
        public ?int        $page = null,
        public ?Uuid       $idempotencyKey = null
    )
    {
    }
}