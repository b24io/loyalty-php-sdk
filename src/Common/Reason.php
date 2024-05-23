<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

class Reason
{
    /**
     * @readonly
     */
    public string $id;
    /**
     * @readonly
     */
    public string $code;
    /**
     * @readonly
     */
    public string $comment;
    public function __construct(string $id, string $code, string $comment)
    {
        $this->id = $id;
        $this->code = $code;
        $this->comment = $comment;
    }
    /**
     * @return array<string, string>
     */
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