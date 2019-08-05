<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\Operations;

use B24io\Loyalty\SDK\Transport\DTO\Reason;

/**
 * Class AbstractOperation
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
abstract class AbstractOperation
{
    /**
     * @var string
     */
    protected $operationCode;
    /**
     * @var \DateTime
     */
    protected $created;
    /**
     * @var Reason
     */
    protected $reason;

    /**
     * @return string
     */
    public function getOperationCode(): string
    {
        return $this->operationCode;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return Reason
     */
    public function getReason(): Reason
    {
        return $this->reason;
    }
}