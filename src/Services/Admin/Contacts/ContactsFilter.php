<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Contacts;

class ContactsFilter
{
    private ?string $name = null;
    private ?string $surname = null;
    private ?string $patronymic = null;
    private ?bool $hasCard = null;
    private ?string $mobilePhone = null;

    public function withName(string $name): ContactsFilter
    {
        $this->name = $name;
        return $this;
    }

    public function withSurname(string $surname): ContactsFilter
    {
        $this->surname = $surname;
        return $this;
    }

    public function withPatronymic(string $patronymic): ContactsFilter
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    public function withHasCard(bool $hasCard): ContactsFilter
    {
        $this->hasCard = $hasCard;
        return $this;
    }

    public function withMobilePhone(string $mobilePhone): ContactsFilter
    {
        $this->mobilePhone = $mobilePhone;
        return $this;
    }

    public function build(): string
    {
        $filter = [];
        if ($this->name !== null) {
            $filter['name'] = $this->name;
        }
        if ($this->surname !== null) {
            $filter['surname'] = $this->surname;
        }
        if ($this->patronymic !== null) {
            $filter['patronymic'] = $this->patronymic;
        }
        if ($this->hasCard !== null) {
            $filter['is_has_card'] = $this->hasCard ? 'true' : 'false';
        }
        if ($this->mobilePhone !== null) {
            $filter['mobile_phone'] = $this->mobilePhone;
        }

        return '?' . http_build_query($filter);
    }
}