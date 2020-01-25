<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\DTO;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class OperationType
 *
 * @method EMERGENCY();
 * @method ALERT();
 * @method CRITICAL();
 * @method ERROR();
 * @method WARNING();
 * @method NOTICE();
 * @method INFO();
 * @method DEBUG();
 *
 */
class LogLevel extends AbstractEnumeration
{
    public const EMERGENCY = 'emergency';
    public const ALERT = 'alert';
    public const CRITICAL = 'critical';
    public const ERROR = 'error';
    public const WARNING = 'warning';
    public const NOTICE = 'notice';
    public const INFO = 'info';
    public const DEBUG = 'debug';
}