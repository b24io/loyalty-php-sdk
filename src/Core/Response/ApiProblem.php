<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response;

readonly class ApiProblem
{
    public function __construct(
        public string $title,
        public string $type,
        public int    $status,
        public string $detail,
        public string $instance,
    )
    {
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['type'],
            $data['status'],
            $data['detail'],
            $data['instance'],
        );
    }
}