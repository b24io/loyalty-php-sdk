<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Cards;

use B24io\Loyalty\SDK\Common\FullName;
use B24io\Loyalty\SDK\Common\Gender;
use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Common\Requests\OrderDirection;
use B24io\Loyalty\SDK\Common\Result\Cards\CardItemResult;
use B24io\Loyalty\SDK\Common\Result\Cards\CardStatus;
use B24io\Loyalty\SDK\Core\Exceptions\BadRequestException;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Tests\Integration\IntegrationTestsContextBuilder;
use DateTimeZone;
use Generator;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;
use Money\Currency;
use Money\Money;
use MoneyPHP\Percentage\Percentage;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Random\RandomException;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Faker;
use Throwable;

class CardsTest extends TestCase
{
    private AdminServiceBuilder $sb;
    private Faker\Generator $faker;
    private PhoneNumberUtil $phoneNumberUtil;

    /**
     * @return void
     * @throws TransportExceptionInterface
     * @throws BaseException
     * @testdox call cards list with nullable arguments
     * @covers \B24io\Loyalty\SDK\Services\Admin\Cards\Cards::list
     */
    public function testGetCardsListWithoutArguments(): void
    {
        $res = $this->sb->cardsScope()->cards()->list(null, null);
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
        $this->assertGreaterThanOrEqual(0, $res->getCoreResponse()->getResponseData()->pagination->total);
        $this->assertGreaterThanOrEqual(0, $res->getCards());
    }

    /**
     * @throws BaseException
     * @throws RandomException
     * @throws NumberParseException
     */
    public function testAddCard(): void
    {
        $addedContact = $this->sb->contactsScope()->contacts()->add(
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

        $contactId = $addedContact->getContact()->id;
        $cardNumber = (string)time();
        $cardBalance = new Money(random_int(1000, 1000000), new Currency('RUB'));
        $cardPercentage = new Percentage('5.5');
        $cardStatus = CardStatus::active;

        $addedCard = $this->sb->cardsScope()->cards()->add(
            $contactId,
            $cardNumber,
            $cardBalance,
            $cardPercentage,
            $cardStatus
        );

        $this->assertEquals($cardNumber, $addedCard->getCard()->number,
            sprintf('expected «%s» card number, but «%s» number returned',
                $cardNumber,
                $addedCard->getCard()->number));
        $this->assertEquals(
            $cardBalance->getAmount(),
            $addedCard->getCard()->balance->getAmount(),
            sprintf('for card with id %s and number %s expected balance «%s», but «%s» balance returned',
                $addedCard->getCard()->id->toRfc4122(),
                $cardNumber,
                $cardBalance->getAmount(),
                $addedCard->getCard()->balance->getAmount()
            )
        );
        $this->assertEquals(
            $cardPercentage->format(),
            $addedCard->getCard()->percentage->format()
        );
        $this->assertEquals(
            $cardStatus,
            $addedCard->getCard()->status
        );
    }

    /**
     * @return void
     * @throws TransportExceptionInterface
     * @throws BaseException
     * @testdox call cards list with default arguments
     * @covers \B24io\Loyalty\SDK\Services\Admin\Cards\Cards::list
     */
    public function testGetCardsListWithDefaultArguments(): void
    {
        $res = $this->sb->cardsScope()->cards()->list();
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
        $this->assertGreaterThanOrEqual(0, $res->getCoreResponse()->getResponseData()->pagination->total);
        $this->assertGreaterThanOrEqual(0, $res->getCards());
    }

    /**
     * @param ItemsOrder $order
     * @param callable|null $validator
     * @param class-string<Throwable>|null $expectedExceptionClassname
     * @return void
     * @throws BaseException
     * @throws TransportExceptionInterface
     * @dataProvider orderDataProvider
     * @testdox call cards list with default arguments
     * @covers       \B24io\Loyalty\SDK\Services\Admin\Cards\Cards::list
     */
    public function testCardsListWithOrder(
        ItemsOrder $order,
        ?callable  $validator,
        ?string    $expectedExceptionClassname): void
    {
        if ($expectedExceptionClassname !== null) {
            $this->expectException($expectedExceptionClassname);
        }

        $res = $this->sb->cardsScope()->cards()->list($order);
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
        $this->assertGreaterThanOrEqual(0, $res->getCoreResponse()->getResponseData()->pagination->total);
        $this->assertGreaterThanOrEqual(0, $res->getCards());
        if ($validator !== null) {
            $validator($order, $res->getCards());
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
                 * @phpstan-param CardItemResult[] $cards
                 */
                array      $cards) {
                $prev = null;
                foreach ($cards as $cnt => $card) {
                    print($card->created->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var CardItemResult $card
                     */
                    if ($prev === null) {
                        $prev = $card->created;
                        continue;
                    }
                    if ($prev->getTimestamp() < $card->created->getTimestamp()) {
                        self::fail(sprintf('Card #%d created at %s is not less than previous card #%d created at %s',
                            $cnt,
                            $card->created->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $card->created;
                }
            },
            null,
        ];
        yield 'order by created asc' => [
            new ItemsOrder('created', OrderDirection::asc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param CardItemResult[] $cards
                 */
                array      $cards) {
                $prev = null;
                foreach ($cards as $cnt => $card) {
                    print($card->created->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var CardItemResult $card
                     */
                    if ($prev === null) {
                        $prev = $card->created;
                        continue;
                    }
                    if ($prev->getTimestamp() > $card->created->getTimestamp()) {
                        self::fail(sprintf('Card #%d created at %s is not greater than previous card #%d created at %s',
                            $cnt,
                            $card->created->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $card->created;
                }
            },
            null
        ];
        yield 'order by modified desc' => [
            new ItemsOrder('modified', OrderDirection::desc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param CardItemResult[] $cards
                 */
                array      $cards) {
                $prev = null;
                foreach ($cards as $cnt => $card) {
                    print($card->modified->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var CardItemResult $card
                     */
                    if ($prev === null) {
                        $prev = $card->modified;
                        continue;
                    }
                    if ($prev->getTimestamp() < $card->modified->getTimestamp()) {
                        self::fail(sprintf('Card #%d modified at %s is not greater than previous card #%d modified at %s',
                            $cnt,
                            $card->modified->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $card->modified;
                }
            },
            null
        ];
        yield 'order by modified asc' => [
            new ItemsOrder('modified', OrderDirection::asc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param CardItemResult[] $cards
                 */
                array      $cards) {
                $prev = null;
                foreach ($cards as $cnt => $card) {
                    print($card->modified->format('Y-m-d H:i:s') . PHP_EOL);
                    /**
                     * @var CardItemResult $card
                     */
                    if ($prev === null) {
                        $prev = $card->modified;
                        continue;
                    }
                    if ($prev->getTimestamp() > $card->modified->getTimestamp()) {
                        self::fail(sprintf('Card #%d modified at %s is not greater than previous card #%d modified at %s',
                            $cnt,
                            $card->modified->format('Y-m-d H:i:s'),
                            $cnt - 1,
                            $prev->format('Y-m-d H:i:s')
                        ));
                    }
                    $prev = $card->modified;
                }
            },
            null
        ];
        yield 'order by balance desc' => [
            new ItemsOrder('balance', OrderDirection::desc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param CardItemResult[] $cards
                 */
                array      $cards) {

                $prev = null;
                foreach ($cards as $cnt => $card) {
                    /**
                     * @var CardItemResult $card
                     */
                    print(sprintf('%s | %s | %s', $cnt, $card->number, $card->balance->getAmount()) . PHP_EOL);
                    if ($prev === null) {
                        $prev = $card->balance;
                        continue;
                    }

                    if ($prev->lessThan($card->balance)) {
                        self::fail(sprintf('Card #%d with balance %s is greater than previous card #%d with balance %s',
                            $cnt,
                            $card->balance->getAmount(),
                            $cnt - 1,
                            $prev->getAmount()
                        ));
                    }
                    $prev = $card->balance;
                }
            },
            null
        ];
        yield 'order by balance asc' => [
            new ItemsOrder('balance', OrderDirection::asc),
            static function (
                ItemsOrder $itemsOrder,
                /**
                 * @phpstan-param CardItemResult[] $cards
                 */
                array      $cards) {
                $prev = null;
                foreach ($cards as $cnt => $card) {
                    /**
                     * @var CardItemResult $card
                     */
                    print(sprintf('%s | %s | %s', $cnt, $card->number, $card->balance->getAmount()) . PHP_EOL);
                    if ($prev === null) {
                        $prev = $card->balance;
                        continue;
                    }

                    if ($prev->greaterThan($card->balance)) {
                        self::fail(sprintf('Card #%d with balance %s is not greater than previous card #%d with balance %s',
                            $cnt,
                            $card->balance->getAmount(),
                            $cnt - 1,
                            $prev->getAmount()
                        ));
                    }
                    $prev = $card->balance;
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

    /**
     * @return void
     * @throws BaseException
     * @covers Cards::count()
     * @testdox Test count cards method
     */
    public function testCount():void
    {
        $cnt = $this->sb->cardsScope()->cards()->count();
        $this->assertGreaterThan(0, $cnt);
    }

    public function setUp(): void
    {
        $this->sb = IntegrationTestsContextBuilder::getAdminServiceBuilder();
        $this->faker = Faker\Factory::create('ru_RU');
        $this->phoneNumberUtil = PhoneNumberUtil::getInstance();
    }
}