<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Contacts;

use B24io\Loyalty\SDK\Common\FullName;
use B24io\Loyalty\SDK\Common\Gender;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Contacts\ContactsFilter;
use B24io\Loyalty\SDK\Tests\Integration\Fabric;
use libphonenumber\PhoneNumber;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class ContactsTest extends TestCase
{
    protected AdminServiceBuilder $sb;

    public function testAdd():void
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();

        $res = $this->sb->contacts()->add(
            new FullName('Иван', 'Иванов', 'Иванович'),
            new \DateTimeZone('Europe/Moscow'),
            Gender::male,
            $phoneUtil->parse('+79000000000', 'RU'),
            null,
            ['mobile_backend' => '1234567890']
        );
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function testContactsList(): void
    {
        $res = $this->sb->contacts()->list();
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
    }

    public function testContactsListWithCard(): void
    {
        $res = $this->sb->contacts()->list(
            (new ContactsFilter())
                ->withHasCard(true));
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
    }

    public function setUp(): void
    {
        $this->sb = Fabric::getAdminServiceBuilder();
    }
}