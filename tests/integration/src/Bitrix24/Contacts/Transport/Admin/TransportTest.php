<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\Admin;

use B24io\Loyalty\SDK\Tests\TestEnvironmentManager;
use B24io\Loyalty\SDK\Users\DTO\Email;
use PHPUnit\Framework\TestCase;

/**
 * Class TransportTest
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\Admin
 */
final class TransportTest extends TestCase
{
    /**
     * @var Transport
     */
    protected $contactsTransport;

    /**
     * @covers \B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\Admin\Transport::filterContactsByEmail
     * @throws \B24io\Loyalty\SDK\Exceptions\ApiClientException
     * @throws \B24io\Loyalty\SDK\Exceptions\BaseLoyaltyException
     * @throws \B24io\Loyalty\SDK\Exceptions\NetworkException
     * @throws \B24io\Loyalty\SDK\Exceptions\ObjectInitializationException
     * @throws \B24io\Loyalty\SDK\Exceptions\TransportFormatException
     * @throws \B24io\Loyalty\SDK\Exceptions\UnknownException
     */
    public function testFilterContactsByEmailWithEmptyResult(): void
    {
        $filtrationResult = $this->contactsTransport->filterContactsByEmail(new Email('loyalty.test@b24.io'));
        $this->assertEquals(0, $filtrationResult->getFiltrationResultCollection()->count());
    }

    /**
     * @covers \B24io\Loyalty\SDK\Bitrix24\Contacts\Transport\Admin\Transport::filterContactsByPhone
     * @throws \B24io\Loyalty\SDK\Exceptions\ApiClientException
     * @throws \B24io\Loyalty\SDK\Exceptions\BaseLoyaltyException
     * @throws \B24io\Loyalty\SDK\Exceptions\NetworkException
     * @throws \B24io\Loyalty\SDK\Exceptions\ObjectInitializationException
     * @throws \B24io\Loyalty\SDK\Exceptions\TransportFormatException
     * @throws \B24io\Loyalty\SDK\Exceptions\UnknownException
     * @throws \libphonenumber\NumberParseException
     */
    public function testFilterContactsByPhoneWithEmptyResult(): void
    {
        $phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
        $mobileNumber = $phoneUtil->parse('+79780000000');

        $filtrationResult = $this->contactsTransport->filterContactsByPhone($mobileNumber);
        $this->assertEquals(0, $filtrationResult->getFiltrationResultCollection()->count());
    }

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        $this->contactsTransport = Fabric::getBitrix24ContactsTransport(
            TestEnvironmentManager::getPhpSdkApiClientForRoleAdmin(),
            TestEnvironmentManager::getApiClientLogger()
        );
    }
}