<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Result;

use B24io\Loyalty\SDK\Core\Response\Response;

abstract class AbstractResult
{
    public function __construct(protected Response $coreResponse)
    {
    }

    public function getCoreResponse(): Response
    {
        return $this->coreResponse;
    }
}