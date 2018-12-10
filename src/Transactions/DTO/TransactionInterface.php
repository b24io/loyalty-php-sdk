<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\DTO;

use B24io\Loyalty\SDK\Transport\DTO\OperationId;
use B24io\Loyalty\SDK\Transport\DTO\Reason;
use Money\Money;

/**
 * Interface TransactionInterface
 *
 * @package B24io\Loyalty\SDK\Transactions\DTO
 */
interface TransactionInterface
{
    /**
     * @return OperationId
     */
    public function getOperationId(): OperationId;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime;

    /**
     * @return Money
     */
    public function getValue(): Money;

    /**
     * @return Reason
     */
    public function getReason(): Reason;

    /**
     * @return int
     */
    public function getCardNumber(): int;
}