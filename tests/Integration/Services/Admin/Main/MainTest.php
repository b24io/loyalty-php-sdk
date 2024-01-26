<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Services\Admin\Main;

use B24io\Loyalty\SDK\Services\Admin\AdminServiceBuilder;
use B24io\Loyalty\SDK\Tests\Integration\Fabric;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;

class MainTest extends TestCase
{
    protected AdminServiceBuilder $sb;

    public function testCallHealthMethod(): void
    {
        $res = $this->sb->main()->health();
        var_dump($res->getResponseData());
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->httpResponse->getStatusCode());

    }

    public function setUp(): void
    {
        $this->sb = Fabric::getAdminServiceBuilder();
    }
}