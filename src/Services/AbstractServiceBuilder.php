<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services;


use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractServiceBuilder
{
    protected CoreInterface $core;
    protected LoggerInterface $log;
    /**
     * @var array<string, mixed>
     */
    protected array $serviceCache;

    public function __construct(
        CoreInterface $core,
        LoggerInterface $log
    ) {
        $this->core = $core;
        $this->log = $log;
    }
}