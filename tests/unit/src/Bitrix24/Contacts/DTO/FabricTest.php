<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

use B24io\Loyalty\SDK\Exceptions\ObjectInitializationException;
use PHPUnit\Framework\TestCase;

/**
 * Class FabricTest
 *
 * @package B24io\Loyalty\SDK\Cards\DTO
 */
final class FabricTest extends TestCase
{
    /**
     * @param $contactItem
     *
     * @throws ObjectInitializationException
     * @covers       \B24io\Loyalty\SDK\Bitrix24\Contacts\DTO\Fabric::initContactFromArray
     * @dataProvider contactsDataProvider
     */
    public function testInitContactFromArrayFromArray($contactItem): void
    {
        $contactDto = Fabric::initContactFromArray($contactItem);
        $this->assertEquals($contactItem['id'], $contactDto->getContactId()->getId());
        $this->assertEquals($contactItem['name'], $contactDto->getName());
        $this->assertEquals($contactItem['second_name'], $contactDto->getSecondName());
        $this->assertEquals($contactItem['last_name'], $contactDto->getLastName());
        $this->assertEquals($contactItem['birthday'], $contactDto->getBirthday());
        $this->assertEquals($contactItem['comments'], $contactDto->getComments());
        $this->assertEquals($contactItem['created'], $contactDto->getCreated()->format(\DATE_RFC3339));
        $this->assertEquals($contactItem['modified'], $contactDto->getModified()->format(\DATE_RFC3339));
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function contactsDataProvider(): array
    {
        return [
            'minimal exists contact data structure' => [
                [
                    'id'                 => 1,
                    'name'               => 'ivan',
                    'second_name'        => 'ivanov',
                    'last_name'          => 'ivanovich',
                    'birthday'           => null,
                    'comments'           => null,
                    'created'            => (new \DateTime())->format(\DATE_RFC3339),
                    'modified'           => (new \DateTime())->format(\DATE_RFC3339),
                    'mobile_phone'       => null,
                    'email'              => null,
                    'address'            => null,
                    'origin_id'          => null,
                    'originator_id'      => null,
                    'source_description' => null,
                    'utm'                => null,
                ],
            ],
            'phone and email'                       => [
                [
                    'id'                 => 1,
                    'name'               => 'ivan',
                    'second_name'        => 'ivanov',
                    'last_name'          => 'ivanovich',
                    'birthday'           => null,
                    'comments'           => null,
                    'created'            => (new \DateTime())->format(\DATE_RFC3339),
                    'modified'           => (new \DateTime())->format(\DATE_RFC3339),
                    'mobile_phone'       => [
                        'national_number' => '9780000000',
                        'country_code'    => '7',
                    ],
                    'email'              => 'test@b24.io',
                    'address'            => null,
                    'origin_id'          => null,
                    'originator_id'      => null,
                    'source_description' => null,
                    'utm'                => null,
                ],
            ],
        ];
    }
}