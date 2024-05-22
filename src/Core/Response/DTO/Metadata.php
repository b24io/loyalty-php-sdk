<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response\DTO;

use B24io\Loyalty\SDK\Core\Credentials\Context;
use DateTimeImmutable;
use Exception;

class Metadata
{
    /**
     * @readonly
     */
    public DateTimeImmutable $requestStartTime;
    /**
     * @readonly
     */
    public string $requestId;
    /**
     * @readonly
     */
    public Context $role;
    /**
     * @readonly
     */
    public float $duration;
    /**
     * @readonly
     */
    public string $message;

    public function __construct(
        DateTimeImmutable $requestStartTime,
        string            $requestId,
        Context           $role,
        float             $duration,
        string            $message)
    {
        $this->requestStartTime = $requestStartTime;
        $this->requestId = $requestId;
        $this->role = $role;
        $this->duration = $duration;
        $this->message = $message;
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
            new Context($metadata['role']),
            $metadata['duration'],
            $metadata['message']
        );
    }
}