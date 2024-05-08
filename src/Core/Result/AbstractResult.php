<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Result;

use B24io\Loyalty\SDK\Core\Response\Response;

abstract class AbstractResult
{
    protected Response $coreResponse;

    public function __construct(Response $coreResponse)
    {
        $this->coreResponse = $coreResponse;
    }

    public function getCoreResponse(): Response
    {
        return $this->coreResponse;
    }
}