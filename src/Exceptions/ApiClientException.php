<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Exceptions;

use Crell\ApiProblem\ApiProblem;
use Throwable;

/**
 * Class ApiClientException
 *
 * @package B24io\Loyalty\SDK\Exceptions
 */
class ApiClientException extends BaseLoyaltyException
{
    /**
     * @var ApiProblem|null
     */
    protected $apiProblem;

    /**
     * ApiClientException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param Throwable|null  $previous
     * @param ApiProblem|null $apiProblem
     */
    public function __construct(string $message = '', int $code = 0, Throwable $previous = null, ?ApiProblem $apiProblem = null)
    {
        $this->apiProblem = $apiProblem;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ApiProblem|null
     */
    public function getApiProblem(): ?ApiProblem
    {
        return $this->apiProblem;
    }
}