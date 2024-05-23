<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services;

use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use libphonenumber\PhoneNumberUtil;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use Psr\Log\LoggerInterface;

abstract class AbstractService
{
    /**
     * @readonly
     */
    public CoreInterface $core;
    /**
     * @readonly
     */
    protected LoggerInterface $log;
    /**
     * @readonly
     */
    protected DecimalMoneyFormatter $decimalMoneyFormatter;
    /**
     * @readonly
     */
    protected PhoneNumberUtil $phoneNumberUtil;

    public function __construct(CoreInterface $core, LoggerInterface $log)
    {
        $this->core = $core;
        $this->log = $log;
        $this->decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }
}