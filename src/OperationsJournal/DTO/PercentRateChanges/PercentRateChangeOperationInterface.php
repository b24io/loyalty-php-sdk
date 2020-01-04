<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges;

use B24io\Loyalty\SDK\Cards\DTO\Percentage;

/**
 * Interface PercentRateChangeOperationInterface
 *
 * @package B24io\Loyalty\SDK\OperationsJournal\DTO\PercentRateChanges\
 */
interface PercentRateChangeOperationInterface
{
    /**
     * @return Percentage
     */
    public function getPercentage(): Percentage;
}