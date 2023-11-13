<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

readonly class Reason
{
    public function __construct(
        public string $id,
        public string $code,
        public string $comment,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'comment' => $this->comment,
        ];
    }

    public function equal(Reason $reason): bool
    {
        return $this->id === $reason->id
            && $this->code === $reason->code
            && $this->comment === $reason->comment;
    }
}