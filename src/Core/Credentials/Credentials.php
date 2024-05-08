<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Credentials;

use Symfony\Component\Uid\Uuid;

readonly class Credentials
{
    public function __construct(
        public string $domainUrl,
        public Uuid   $clientId,
        public ?Uuid   $adminApiKey)
    {
    }
}