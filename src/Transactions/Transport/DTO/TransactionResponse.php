<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transactions\Transport\DTO;

use B24io\Loyalty\SDK\Transactions\DTO\TransactionInterface;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class TransactionResponse
 *
 * @package B24io\Loyalty\SDK\Turnover\Transport\DTO
 */
class TransactionResponse
{
    /**
     * @var Metadata
     */
    private $meta;
    /**
     * @var TransactionInterface
     */
    private $transaction;

    /**
     * TransactionResponse constructor.
     *
     * @param Metadata             $meta
     * @param TransactionInterface $transaction
     */
    public function __construct(Metadata $meta, TransactionInterface $transaction)
    {
        $this->meta = $meta;
        $this->transaction = $transaction;
    }

    /**
     * @return Metadata
     */
    public function getMeta(): Metadata
    {
        return $this->meta;
    }

    /**
     * @return TransactionInterface
     */
    public function getTransaction(): TransactionInterface
    {
        return $this->transaction;
    }
}