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
    protected readonly DecimalMoneyFormatter $decimalMoneyFormatter;
    protected readonly PhoneNumberUtil $phoneNumberUtil;

    public function __construct(public readonly CoreInterface $core, protected readonly LoggerInterface $log)
    {
        $this->decimalMoneyFormatter = new DecimalMoneyFormatter(new ISOCurrencies());
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }
}