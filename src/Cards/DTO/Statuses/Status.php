<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO\Statuses;

/**
 * Class Status
 *
 * @package B24io\Loyalty\SDK\Cards\DTO\Statuses
 */
abstract class Status implements StatusInterface
{
    /**
     * @var string
     */
    protected $code;

    /**
     * Status constructor.
     *
     * @param string $statusCode
     */
    public function __construct(string $statusCode)
    {
        $this->code = $statusCode;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}