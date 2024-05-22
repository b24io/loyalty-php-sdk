<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Exceptions;

use B24io\Loyalty\SDK\Core\Response\ApiProblem;
use Throwable;

class InternalServerErrorException extends BaseException
{
    public function __construct(
        protected ApiProblem $apiProblem,
        string     $message = "",
        int        $code = 0,
        ?Throwable $previous = null,
    )
    {
        parent::__construct($message, $code, $previous);
    }

    public function getApiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }
}