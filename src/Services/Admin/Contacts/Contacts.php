<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Services\Admin\Contacts;

use B24io\Loyalty\SDK\Common\FullName;
use B24io\Loyalty\SDK\Common\Gender;
use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Response\Response;
use B24io\Loyalty\SDK\Services\AbstractService;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardItemResult;
use B24io\Loyalty\SDK\Services\Admin\Cards\Result\CardsResult;
use B24io\Loyalty\SDK\Services\Admin\Contacts\Result\ContactItemResult;
use B24io\Loyalty\SDK\Services\Admin\Contacts\Result\ContactsResult;
use DateTimeImmutable;
use DateTimeZone;
use Fig\Http\Message\RequestMethodInterface;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Symfony\Component\Uid\Uuid;


class Contacts extends AbstractService
{
    public function add(
        FullName           $fullName,
        DateTimeZone       $timezone,
        Gender             $gender,
        PhoneNumber        $mobilePhone,
        ?DateTimeImmutable $birthdate = null,
        array              $externalIds = []
    )
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        $res = $this->core->call(
            new Command(
                Context::admin,
                RequestMethodInterface::METHOD_POST,
                'contacts',
                [
                    'full_name' => $fullName->toArray(),
                    'timezone' => $timezone->getName(),
                    'gender' => $gender->name,
                    'birthday' => $birthdate?->format('Y.m.d'),
                    'mobile_phone' => $phoneUtil->format($mobilePhone, PhoneNumberFormat::E164),
                    'external_ids' => $externalIds
                ],
                null,
                Uuid::v4()
            ));

        var_dump($res->getResponseData()->result);
        return $res;
    }


    public function getById(Uuid $id): ContactItemResult
    {
        return new ContactItemResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    sprintf('contacts/%s', $id->toRfc4122()),
                )
            )->getResponseData()->result
        );
    }

    public function list(?ContactsFilter $filter = null, ?int $page = 1): ContactsResult
    {
        $url = 'contacts';
        if (!is_null($filter)) {
            $url .= $filter->build();
        }

        return new ContactsResult(
            $this->core->call(
                new Command(
                    Context::admin,
                    RequestMethodInterface::METHOD_GET,
                    $url,
                    [],
                    $page
                )
            )
        );
    }
}