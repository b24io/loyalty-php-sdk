<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

readonly class FullName
{
    public function __construct(
        public string  $name,
        public ?string $surname = null,
        public ?string $patronymic = null
    )
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic
        ];
    }
}