<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Contracts;

use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Credentials\Credentials;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiClientInterface
{
    /**
     * @param Context $context
     * @param string $httpMethod
     * @param string $apiMethod
     * @param array<string, mixed> $parameters
     * @param ItemsOrder|null $order
     * @param int|null $page
     * @param Uuid|null $idempotencyKey
     * @return ResponseInterface
     */
    public function getResponse(
        Context     $context,
        string      $httpMethod,
        string      $apiMethod,
        array       $parameters = [],
        ?ItemsOrder $order = null,
        ?int        $page = null,
        ?Uuid       $idempotencyKey = null
    ): ResponseInterface;

    public function getCredentials(): Credentials;
}