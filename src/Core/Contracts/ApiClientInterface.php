<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Contracts;

use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Credentials\Credentials;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface ApiClientInterface
{
    public function getResponse(
        Context $context,
        string  $httpMethod,
        string  $apiMethod,
        array   $parameters = [],
        ?int    $page = null,
        ?Uuid   $idempotencyKey = null
    ): ResponseInterface;

    public function getCredentials(): Credentials;
}