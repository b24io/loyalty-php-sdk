<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Credentials;

use Symfony\Component\Uid\Uuid;

class Credentials
{
    /**
     * @readonly
     */
    public string $domainUrl;
    /**
     * @readonly
     */
    public Uuid $clientId;
    /**
     * @readonly
     */
    public ?Uuid $adminApiKey;

    public function __construct(
        string $domainUrl,
        Uuid   $clientId,
        ?Uuid  $adminApiKey)
    {
        $this->domainUrl = $domainUrl;
        $this->clientId = $clientId;
        $this->adminApiKey = $adminApiKey;
    }
}