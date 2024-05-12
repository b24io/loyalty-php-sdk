<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core;

use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use Symfony\Component\Uid\Uuid;

class Command
{
    /**
     * @var Context
     * @readonly
     */
    public Context $context;
    /**
     * @var string
     * @readonly
     */
    public string $httpMethod;
    /**
     * @var string
     * @readonly
     */
    public string $apiMethod;
    /**
     * @var array<string, mixed>
     * @readonly
     */
    public array $parameters = [];
    /**
     * @var ItemsOrder|null
     * @readonly
     */
    public ?ItemsOrder $itemsOrder = null;
    /**
     * @var int|null
     * @readonly
     */
    public ?int $page = null;
    /**
     * @var Uuid|null
     * @readonly
     */
    public ?Uuid $idempotencyKey = null;

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
        Context     $context,
        string      $httpMethod,
        string      $apiMethod,
        array       $parameters = [],
        ?ItemsOrder $itemsOrder = null,
        ?int        $page = null,
        ?Uuid       $idempotencyKey = null)
    {
        $this->context = $context;
        $this->httpMethod = $httpMethod;
        $this->apiMethod = $apiMethod;
        $this->parameters = $parameters;
        $this->itemsOrder = $itemsOrder;
        $this->page = $page;
        $this->idempotencyKey = $idempotencyKey;
    }
}