<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Contacts;

use B24io\Loyalty\SDK\Common\FullName;
use B24io\Loyalty\SDK\Common\Gender;
use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Common\Requests\OrderDirection;
use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Common\Result\Contacts\ContactItemResult;
use B24io\Loyalty\SDK\Core\Exceptions\BadRequestException;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Services\Admin\Contacts\ContactsFilter;
use B24io\Loyalty\SDK\Tests\Integration\IntegrationTestsContextBuilder;
use Generator;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberUtil;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Faker;
use DateTimeZone;
use Throwable;

class ContactsTest extends TestCase
{
    private AdminServiceBuilder $sb;
    private Faker\Generator $faker;
    private PhoneNumberUtil $phoneNumberUtil;

    public function testAdd(): void
    {
        $addedContact = $this->sb->contacts()->add(
            new FullName(
                $this->faker->firstName(),
                $this->faker->lastName(),
            ),
            new DateTimeZone('Europe/Moscow'),
            Gender::male,
            $this->phoneNumberUtil->parse(
                $this->faker->phoneNumber,
                'RU'
            )
        );
        $this->assertEquals(
            StatusCodeInterface::STATUS_OK,
            $addedContact->getCoreResponse()->httpResponse->getStatusCode()
        );
    }

    /**
     * @throws TransportExceptionInterface|BaseException
     * @testdox Get contacts list with null arguments - test default options on server side
     * @covers \B24io\Loyalty\SDK\Services\Admin\Contacts\Contacts::list
     */
    public function testContactsListWithNullArguments(): void
    {
        $res = $this->sb->contacts()->list(null, null, null);
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
        $this->assertGreaterThanOrEqual(0, $res->getCoreResponse()->getResponseData()->pagination->total);
        $this->assertGreaterThanOrEqual(0, count($res->getContacts()));
    }

    /**
     * @throws TransportExceptionInterface|BaseException
     * @testdox Get contacts list with null arguments - test default options on client side
     * @covers \B24io\Loyalty\SDK\Services\Admin\Contacts\Contacts::list
     */
    public function testContactsListWithDefaultArguments(): void
    {
        $res = $this->sb->contacts()->list();
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
        $this->assertGreaterThanOrEqual(0, $res->getCoreResponse()->getResponseData()->pagination->total);
        $this->assertGreaterThanOrEqual(0, count($res->getContacts()));
    }

    /**
     * @param ItemsOrder $order
     * @param callable|null $validator
     * @param class-string<Throwable>|null $expectedExceptionClassname
     * @return void
     * @throws BaseException
     * @throws TransportExceptionInterface
     * @dataProvider orderDataProvider
     * @covers       \B24io\Loyalty\SDK\Services\Admin\Contacts\Contacts::list()
     * @testdox Test contacts list with all possible order by fields, directions and corner cases
     */
    public function testContactsListWithOrder(
        ItemsOrder $order,
        ?callable  $validator,
        ?string    $expectedExceptionClassname
    ): void
    {
        if ($expectedExceptionClassname !== null) {
            $this->expectException($expectedExceptionClassname);
        }

        $res = $this->sb->contacts()->list(null, $order);
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
        $this->assertGreaterThanOrEqual(0, $res->getCoreResponse()->getResponseData()->pagination->total);
        $this->assertGreaterThanOrEqual(0, count($res->getContacts()));

        if ($validator !== null) {
            $validator($order, $res->getContacts());
        }
        sleep(1);
    }

    public static function orderDataProvider(): Generator
    {
        yield 'order by created desc' => [
            new ItemsOrder('created', OrderDirection::desc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param ContactItemResult[] $contacts
                 */
                array      $contacts) {
                $prev = null;
                foreach ($contacts as $cnt => $contact) {
                    print($contact->created->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var ContactItemResult $contact
                     */
                    if ($prev === null) {
                        $prev = $contact->created;
                        continue;
                    }
                    if ($prev->getTimestamp() < $contact->created->getTimestamp()) {
                        self::fail(sprintf('Contact #%d created at %s is not less than previous contact #%d created at %s',
                            $cnt,
                            $contact->created->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $contact->created;
                }
            },
            null,
        ];
        yield 'order by created asc' => [
            new ItemsOrder('created', OrderDirection::asc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param ContactItemResult[] $contacts
                 */
                array      $contacts) {
                $prev = null;
                foreach ($contacts as $cnt => $contact) {
                    print($contact->created->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var ContactItemResult $contact
                     */
                    if ($prev === null) {
                        $prev = $contact->created;
                        continue;
                    }
                    if ($prev->getTimestamp() > $contact->created->getTimestamp()) {
                        self::fail(sprintf('Contact #%d created at %s is not greater than previous contact #%d created at %s',
                            $cnt,
                            $contact->created->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $contact->created;
                }
            },
            null
        ];
        yield 'order by modified desc' => [
            new ItemsOrder('modified', OrderDirection::desc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param ContactItemResult[] $contacts
                 */
                array      $contacts) {
                $prev = null;
                foreach ($contacts as $cnt => $contact) {
                    print($contact->modified->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var ContactItemResult $contact
                     */
                    if ($prev === null) {
                        $prev = $contact->modified;
                        continue;
                    }
                    if ($prev->getTimestamp() < $contact->modified->getTimestamp()) {
                        self::fail(sprintf('Contact #%d modified at %s is not greater than previous contact #%d modified at %s',
                            $cnt,
                            $contact->modified->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $contact->modified;
                }
            },
            null
        ];
        yield 'order by modified asc' => [
            new ItemsOrder('modified', OrderDirection::asc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param ContactItemResult[] $contacts
                 */
                array      $contacts) {
                $prev = null;
                foreach ($contacts as $cnt => $contact) {
                    print($contact->modified->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var ContactItemResult $contact
                     */
                    if ($prev === null) {
                        $prev = $contact->modified;
                        continue;
                    }
                    if ($prev->getTimestamp() > $contact->modified->getTimestamp()) {
                        self::fail(sprintf('Contact #%d modified at %s is not greater than previous contact #%d modified at %s',
                            $cnt,
                            $contact->modified->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $contact->modified;
                }
            },
            null
        ];
        yield 'wrong order by field' => [
            new ItemsOrder('balance1', OrderDirection::desc),
            null,
            BadRequestException::class
        ];
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
        $this->sb = IntegrationTestsContextBuilder::getAdminServiceBuilder();
        $this->faker = Faker\Factory::create('ru_RU');
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }
}