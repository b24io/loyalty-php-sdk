<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\Operations;

/**
 * Class AbstractOperationWithCard
 *
 * @package B24io\Loyalty\SDK\Cards\Operations
 */
abstract class AbstractOperationWithCard extends AbstractOperation
{
    /**
     * @var int
     */
    protected $cardNumber;

    /**
     * @return int
     */
    public function getCardNumber(): int
    {
        return $this->cardNumber;
    }
}