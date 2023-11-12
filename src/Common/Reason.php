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
}