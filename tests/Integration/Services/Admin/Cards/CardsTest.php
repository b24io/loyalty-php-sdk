<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Cards;

use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class CardsTest extends TestCase
{
    protected AdminServiceBuilder $sb;

    /**
     * @throws TransportExceptionInterface
     */
    public function testCardsList(): void
    {
        $res = $this->sb->cardsScope()->cards()->list();
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getCoreResponse()->httpResponse->getStatusCode());
    }

    public function setUp(): void
    {
        $this->sb = Fabric::getAdminServiceBuilder();
    }
}