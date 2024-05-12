<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Tests\Integration;

use B24io\Loyalty\SDK\Services\ServiceBuilderFactory;
use PHPUnit\Framework\TestCase;
use Fig\Http\Message\StatusCodeInterface;
use Fig\Http\Message\RequestMethodInterface;

class ServiceBuilderFactoryTest extends TestCase
{
    public function testDefaultHttpClient(): void
    {
        $httpClient = ServiceBuilderFactory::getDefaultHttpClient();

        $credentials = IntegrationTestsContextBuilder::getCredentials();
        $url = sprintf('%s%s/admin/cards',
            $credentials->domainUrl,
            $credentials->clientId->toRfc4122()
        );
        $res = $httpClient->request(RequestMethodInterface::METHOD_GET,
            $url,
            [
                'headers' => [
                    'X-LOYALTY-API-KEY-ADMIN' => $credentials->adminApiKey?->toRfc4122()
                ],
            ]
        );
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $res->getStatusCode());
    }
}