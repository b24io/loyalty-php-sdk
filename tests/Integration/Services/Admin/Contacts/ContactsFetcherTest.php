<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Contacts;

use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Common\Requests\OrderDirection;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Tests\Integration\IntegrationTestsContextBuilder;
use PHPUnit\Framework\TestCase;

class ContactsFetcherTest extends TestCase
{
    private AdminServiceBuilder $sb;

    /**
     * @return void
     * @throws BaseException
     * @testdox call cards list fetcher with generator
     * @covers \B24io\Loyalty\SDK\Services\Admin\Cards\CardsFetcher::list
     */
    public function testCardsFetcher(): void
    {
        // in parallel, we can run tests for CRUD operations
        $itemCnt = 0;
        foreach ($this->sb->contactsScope()->fetcher()->list(null, new ItemsOrder('created', OrderDirection::desc())) as $item) {
            $itemCnt++;
        }
        $this->assertGreaterThanOrEqual(0, $itemCnt);
    }

    public function setUp(): void
    {
        $this->sb = IntegrationTestsContextBuilder::getAdminServiceBuilder();
    }
}