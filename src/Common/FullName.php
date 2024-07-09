<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common;

class FullName
{
    /**
     * @readonly
     * @var non-empty-string
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

    public function __construct(string $name, ?string $surname = null, ?string $patronymic = null)
    {
        $this->name = trim($name);

        if ($surname !== null) {
            $surname = trim($surname);
        }
        if ($surname === '') {
            $surname = null;
        }
        $this->surname = $surname;

        if ($patronymic !== null) {
            $patronymic = trim($patronymic);
        }
        if ($patronymic === '') {
            $patronymic = null;
        }
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

    public function equals(self $fullName): bool
    {
        return $this->name === $fullName->name && $this->surname === $fullName->surname && $this->patronymic === $fullName->patronymic;
    }
}