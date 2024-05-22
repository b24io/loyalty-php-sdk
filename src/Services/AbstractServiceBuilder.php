<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services;


use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractServiceBuilder
{
    /**
     * @var array<string, mixed>
     */
    protected array $serviceCache;

    public function __construct(protected CoreInterface $core, protected LoggerInterface $log)
    {
    }
}