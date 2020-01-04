<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

/**
 * Class PurchaseId
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
final class PurchaseId
{
    /**
     * @var string
     */
    private $id;

    /**
     * PurchaseId constructor.
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