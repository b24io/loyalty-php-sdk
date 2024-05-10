<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Core;

use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Tests\Integration\IntegrationTestsContextBuilder;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;

class CoreTest extends TestCase
{
    protected CoreInterface $core;

    public function testCallUnknownMethod(): void
    {
        $this->expectException(\B24io\Loyalty\SDK\Core\Exceptions\MethodNotFoundException::class);
        $res = $this->core->call(new Command(
            Context::admin,
            RequestMethodInterface::METHOD_GET,
            'unknownMethod'

        ));
        $this->assertEquals(StatusCodeInterface::STATUS_NOT_FOUND,
            $res->httpResponse->getStatusCode());
    }

    public function testCallHealthMethod(): void
    {
        $res = $this->core->call(new Command(
            Context::admin,
            RequestMethodInterface::METHOD_GET,
            'health'

        ));
        $this->assertEquals(StatusCodeInterface::STATUS_OK,
            $res->httpResponse->getStatusCode());
    }

    public function setUp(): void
    {
        $this->core = IntegrationTestsContextBuilder::getCore();
    }
}