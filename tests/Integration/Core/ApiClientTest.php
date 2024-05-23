<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration\Core;

use B24io\Loyalty\SDK\Core\Contracts\ApiClientInterface;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Tests\Integration\IntegrationTestsContextBuilder;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;

class ApiClientTest extends TestCase
{
    protected ApiClientInterface $apiClient;

    public function testCallUnknownMethod(): void
    {
        $res = $this->apiClient->getResponse(
            Context::admin(),
            RequestMethodInterface::METHOD_GET,
            'unknown');
        $this->assertEquals(StatusCodeInterface::STATUS_NOT_FOUND, $res->getStatusCode());
    }

    public function testCallHealthMethod(): void
    {
        $res = $this->apiClient->getResponse(
            Context::admin(),
            RequestMethodInterface::METHOD_GET,
             'health');
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getStatusCode());
    }

    public function setUp(): void
    {
        $this->apiClient = IntegrationTestsContextBuilder::getApiClient();
    }
}