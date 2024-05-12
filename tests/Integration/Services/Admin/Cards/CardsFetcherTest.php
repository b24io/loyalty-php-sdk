<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Cards;

use B24io\Loyalty\SDK\Common\Requests\ItemsOrder;
use B24io\Loyalty\SDK\Common\Requests\OrderDirection;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Tests\Integration\IntegrationTestsContextBuilder;
use PHPUnit\Framework\TestCase;

class CardsFetcherTest extends TestCase
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
        $cardsCount = $this->sb->cardsScope()->cards()->count();

        $cardCnt = 0;
        foreach ($this->sb->cardsScope()->fetcher()->list(new ItemsOrder('created', OrderDirection::desc)) as $card) {
            $cardCnt++;
        }

        $this->assertGreaterThanOrEqual($cardsCount, $cardCnt);
    }

    public function setUp(): void
    {
        $this->sb = IntegrationTestsContextBuilder::getAdminServiceBuilder();
    }
}