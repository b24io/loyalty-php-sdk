<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core;

use B24io\Loyalty\SDK\Core\Contracts\ApiClientInterface;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use Psr\Log\LoggerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiClient implements ApiClientInterface
{
    protected HttpClientInterface $client;
    protected LoggerInterface $logger;
    protected Credentials\Credentials $credentials;
    protected const SDK_VERSION = '3.0.0';
    protected const SDK_USER_AGENT = 'b24io-loyalty-php-sdk';

    public function __construct(Credentials\Credentials $credentials, HttpClientInterface $client, LoggerInterface $logger)
    {
        $this->credentials = $credentials;
        $this->client = $client;
        $this->logger = $logger;
        $this->logger->debug(
            'ApiClient.init',
            [
                'httpClientType' => get_class($client),
            ]
        );
    }

    /**
     * @return array<string,string>
     */
    protected function getDefaultHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Accept-Charset' => 'utf-8',
            'User-Agent' => sprintf('%s-v-%s-php-%s', self::SDK_USER_AGENT, self::SDK_VERSION, PHP_VERSION),
            'X-BITRIX24-PHP-SDK-PHP-VERSION' => PHP_VERSION,
            'X-BITRIX24-PHP-SDK-VERSION' => self::SDK_VERSION,
        ];
    }

    public function getCredentials(): Credentials\Credentials
    {
        return $this->credentials;
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function getResponse(
        Context $context,
        string  $httpMethod,
        string  $apiMethod,
        array   $parameters = [],
        ?int    $page = null,
        ?Uuid   $idempotencyKey = null
    ): ResponseInterface
    {
        $this->logger->info(
            'getResponse.start',
            [
                'context' => $context->name,
                'apiMethod' => $apiMethod,
                'domainUrl' => $this->credentials->domainUrl,
                'parameters' => $parameters,
            ]
        );


        if ($apiMethod === 'health') {
            $url = sprintf('%s%s',
                $this->getCredentials()->domainUrl,
                $apiMethod);
        } else {
            $url = sprintf('%s%s/%s/%s',
                $this->getCredentials()->domainUrl,
                $this->getCredentials()->clientId->toRfc4122(),
                $context->name,
                $apiMethod);
            if ($page !== null) {
                if (parse_url($url, PHP_URL_QUERY) !== null) {
                    $url .= '&page=' . $page;
                } else {
                    $url .= '?page=' . $page;
                }
            }
        }
        // auth
        $headers = $this->getDefaultHeaders();
        if ($context === Context::admin) {
            $headers['X-LOYALTY-API-KEY-ADMIN'] = $this->getCredentials()->adminApiKey->toRfc4122();
        }
        if ($idempotencyKey !== null) {
            $headers['Idempotency-Key'] = $idempotencyKey->toRfc4122();
        }

        $requestOptions = [
            'json' => $parameters,
            'headers' => $headers,
            'max_redirects' => 0,
        ];
        $response = $this->client->request($httpMethod, $url, $requestOptions);

        $this->logger->info(
            'getResponse.end',
            [
                'apiMethod' => $apiMethod,
                'responseInfo' => $response->getInfo(),
            ]
        );

        return $response;
    }
}