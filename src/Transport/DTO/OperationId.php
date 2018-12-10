<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

/**
 * Class OperationId
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
final class OperationId
{
    /**
     * @var string
     */
    private $id;

    /**
     * OperationId constructor.
     *
     * @param string $operationId
     */
    public function __construct(string $operationId)
    {
        $this->id = $operationId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }
}