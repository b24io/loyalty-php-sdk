<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\DTO;

use B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\FiltrationResultCollection;
use B24io\Loyalty\SDK\Transport\DTO\AbstractResponse;
use B24io\Loyalty\SDK\Transport\DTO\Metadata;

/**
 * Class FiltrationResultResponse
 *
 * @package B24io\Loyalty\SDK\Transactions\Transport\DTO
 */
class FiltrationResultResponse extends AbstractResponse
{
    /**
     * @var FiltrationResultCollection
     */
    private $filtrationResultCollection;

    /**
     * FiltrationResultResponse constructor.
     *
     * @param FiltrationResultCollection $filtrationResultCollection
     * @param Metadata                   $metadata
     */
    public function __construct(FiltrationResultCollection $filtrationResultCollection, Metadata $metadata)
    {
        parent::__construct($metadata);
        $this->filtrationResultCollection = $filtrationResultCollection;
    }

    /**
     * @return FiltrationResultCollection
     */
    public function getFiltrationResultCollection(): FiltrationResultCollection
    {
        return $this->filtrationResultCollection;
    }
}