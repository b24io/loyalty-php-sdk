<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services;

use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Psr\Log\LoggerInterface;

abstract class AbstractService
{
    public readonly CoreInterface $core;
    protected readonly LoggerInterface $log;
    protected readonly DecimalMoneyFormatter $decimalMoneyFormatter;

    public function __construct(CoreInterface $core, LoggerInterface $log)
    {
        $this->core = $core;
        $this->log = $log;
        $this->decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
    }
}