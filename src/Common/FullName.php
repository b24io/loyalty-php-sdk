<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

class FullName
{
    /**
     * @readonly
     */
    public string $name;
    /**
     * @readonly
     */
    public ?string $surname = null;
    /**
     * @readonly
     */
    public ?string $patronymic = null;
    public function __construct(string  $name, ?string $surname = null, ?string $patronymic = null)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->patronymic = $patronymic;
    }

    /**
     * @return array<string, ?string>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic
        ];
    }
}