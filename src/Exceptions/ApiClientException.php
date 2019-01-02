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
     * @var ApiProblem
     */
    protected $apiProblem;

    /**
     * ApiClientException constructor
     *
     * @param ApiProblem     $apiProblem
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(ApiProblem $apiProblem, string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->apiProblem = $apiProblem;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return ApiProblem
     */
    public function getApiProblem(): ApiProblem
    {
        return $this->apiProblem;
    }
}