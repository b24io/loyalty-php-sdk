<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response\DTO;

use B24io\Loyalty\SDK\Core\Credentials\Context;
use DateTimeImmutable;
use Exception;

readonly class Metadata
{
    public function __construct(
        public DateTimeImmutable $requestStartTime,
        public string            $requestId,
        public Context           $role,
        public float             $duration,
        public string            $message
    )
    {
    }

    /**
     * @param array<string, mixed> $metadata
     * @throws Exception
     */
    public static function initFromArray(array $metadata): self
    {
        return new self(
            new DateTimeImmutable($metadata['request_start_time']),
            $metadata['request_id'],
            Context::from($metadata['role']),
            $metadata['duration'],
            $metadata['message']
        );
    }
}