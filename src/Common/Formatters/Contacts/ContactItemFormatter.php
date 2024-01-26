<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Common\Formatters\Contacts;

use B24io\Loyalty\SDK\Common\Result\Contacts\ContactItemResult;

readonly class ContactItemFormatter
{
    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'contact_id',
            'contact_name',
            'contact_surname',
            'contact_patronymic',
            'contact_timezone_name',
            'contact_birthday',
            'contact_gender',
            'contact_external_id',
            'contact_created',
            'contact_modified',
        ];
    }
    /**
     * @return array<string, mixed>
     */
    public function toFlatArray(ContactItemResult $contact, string $externalIdKey): array
    {
        return [
            'contact_id' => $contact->id->toRfc4122(),
            'contact_name' => $contact->fullName->name,
            'contact_surname' => $contact->fullName->surname,
            'contact_patronymic' => $contact->fullName->patronymic,
            'contact_timezone_name' => $contact->timezone->getName(),
            'contact_birthday' => $contact->birthday?->format('Y.m.d'),
            'contact_gender' => $contact->gender->name,
            'contact_external_id' => $contact->externalIds[$externalIdKey],
            'contact_created' => $contact->created->format(DATE_ATOM),
            'contact_modified' => $contact->modified->format(DATE_ATOM),
        ];
    }
}