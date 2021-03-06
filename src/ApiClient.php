<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK;

use B24io\Loyalty\SDK;
use B24io\Loyalty\SDK\Exceptions;
use Crell\ApiProblem\ApiProblem;
use Fig\Http\Message\StatusCodeInterface;
use GuzzleHttp;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ramsey\Uuid\Uuid;

/**
 * Class ApiClient
 *
 * @package B24io\Loyalty\SDK
 */
class ApiClient
{
    /**
     * @var string SDK version
     */
    protected const SDK_VERSION = '2.0.1';
    /**
     * @var string user agent
     */
    protected const API_USER_AGENT = 'b24io.loyalty.php.sdk';
    /**
     * @var GuzzleHttp\ClientInterface
     */
    protected $httpClient;
    /**
     * @var LoggerInterface
     */
    protected $log;
    /**
     * @var GuzzleHttp\HandlerStack
     */
    protected $guzzleHandlerStack;
    /**
     * @var string
     */
    protected $apiEndpoint;
    /**
     * @var SDK\Auth\DTO\Token
     */
    protected $authToken;
    /**
     * @var float number of seconds to wait while trying to connect to a server. Use 0 to wait indefinitely (the default behavior).
     */
    protected $connectTimeout;

    /**
     * ApiClient constructor.
     *
     * @param string                     $apiEndpointUrl
     * @param SDK\Auth\DTO\Token         $authToken
     * @param GuzzleHttp\ClientInterface $obHttpClient
     * @param LoggerInterface|null       $obLogger
     */
    public function __construct(
        string $apiEndpointUrl,
        SDK\Auth\DTO\Token $authToken,
        GuzzleHttp\ClientInterface $obHttpClient,
        LoggerInterface $obLogger = null
    ) {
        if ($obLogger !== null) {
            $this->log = $obLogger;
        } else {
            $this->log = new NullLogger();
        }
        $this->apiEndpoint = $apiEndpointUrl;
        $this->authToken = $authToken;
        $this->httpClient = $obHttpClient;
        $this->setConnectTimeout(2.0);
        $this->guzzleHandlerStack = GuzzleHttp\HandlerStack::create();
        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.init',
            [
                'url'             => $apiEndpointUrl,
                'connect_timeout' => $this->getConnectTimeout(),
            ]
        );
    }

    /**
     * @return float
     */
    public function getConnectTimeout(): float
    {
        return $this->connectTimeout;
    }


    /**
     * @param float $connectTimeout
     *
     * @return ApiClient
     */
    public function setConnectTimeout(float $connectTimeout): ApiClient
    {
        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.setConnectTimeout.start',
            [
                'connectTimeout' => $connectTimeout,
            ]
        );
        $this->connectTimeout = $connectTimeout;
        $this->log->debug('b24io.loyalty.sdk.apiClient.setConnectTimeout.finish');

        return $this;
    }

    /**
     * @param       $apiMethod
     * @param       $requestType
     * @param array $arHttpRequestOptions
     *
     * @return array
     * @throws Exceptions\ApiClientException
     * @throws Exceptions\NetworkException
     * @throws Exceptions\TransportFormatException
     * @throws Exceptions\UnknownException
     */
    public function executeApiRequest($apiMethod, $requestType, array $arHttpRequestOptions = []): array
    {
        if (\count($arHttpRequestOptions) !== 0) {
            $defaultHttpRequestOptions = \array_merge(['json' => $arHttpRequestOptions], $this->getHttpRequestOptions());
        } else {
            $defaultHttpRequestOptions = $this->getHttpRequestOptions();
        }
        if ($this->authToken->getRole()->isUser()) {
            $url = sprintf(
                '%s&loyalty_client_api_key=%s',
                $this->apiEndpoint . $apiMethod,
                $this->authToken->getClientApiKey()->toString()
            );
        } else {
            $url = $this->apiEndpoint . $apiMethod;
        }

        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.executeApiRequest.start',
            [
                'url'          => $url,
                'method'       => $apiMethod,
                'request_type' => $requestType,
                'options'      => $defaultHttpRequestOptions,
            ]
        );
        $obResponse = $this->executeRequest($requestType, $url, $defaultHttpRequestOptions);
        $obResponseBody = $obResponse->getBody();
        $obResponseBody->rewind();

        $result = $this->decodeApiJsonResponse($obResponseBody->getContents());

        $this->handleApiLevelErrors($result, $obResponse->getStatusCode());

        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.executeApiRequest.finish',
            [
                'result' => $result,
            ]
        );

        return $result;
    }

    /**
     * get HttpRequest options
     *
     * @return array
     */
    protected function getHttpRequestOptions(): array
    {
        $result = [
            'connect_timeout' => $this->getConnectTimeout(),
            'headers'         => [
                'Cache-Control'             => 'no-cache',
                'Content-type'              => 'application/json; charset=utf-8',
                'X-LOYALTY-SDK-REQUEST-ID'  => Uuid::uuid4()->toString(),
                'X-ENVIRONMENT-PHP-VERSION' => \PHP_VERSION,
                'X-ENVIRONMENT-SDK-VERSION' => \strtolower(self::API_USER_AGENT . '.' . self::SDK_VERSION),
            ],
        ];
        $result['headers'] = array_merge($result['headers'], SDK\Auth\Formatters\Token::toArray($this->getAuthToken()));

        return $result;
    }

    /**
     * @return SDK\Auth\DTO\Token
     */
    public function getAuthToken(): SDK\Auth\DTO\Token
    {
        return $this->authToken;
    }

    /**
     * @param string $requestType
     * @param string $url
     * @param array  $requestOptions
     *
     * @return \Psr\Http\Message\ResponseInterface
     * @throws Exceptions\ApiClientException
     * @throws Exceptions\NetworkException
     * @throws Exceptions\TransportFormatException
     * @throws Exceptions\UnknownException
     */
    protected function executeRequest(string $requestType, string $url, array $requestOptions): \Psr\Http\Message\ResponseInterface
    {
        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.executeRequest.start',
            [
                'request_type'    => $requestType,
                'url'             => $url,
                'request_options' => $requestOptions,
            ]
        );

        try {
            $obResponse = $this->httpClient->request($requestType, $url, $requestOptions);
            $obResponseBody = $obResponse->getBody();
            $obResponseBody->rewind();

            $result = $this->decodeApiJsonResponse($obResponseBody->getContents());
        } catch (GuzzleHttp\Exception\BadResponseException $exception) {
            // 4xx or 5xx http-status
            $response = $exception->getResponse();
            $responseBodyAsString = '';
            if ($response !== null) {
                $responseBodyAsString = $response->getBody()->getContents();
            }
            $result = $this->decodeApiJsonResponse($responseBodyAsString);
            $this->log->error(
                'b24io.loyalty.sdk.apiClient.backend.error',
                [
                    'code'            => $exception->getCode(),
                    'message'         => $exception->getMessage(),
                    'server_response' => $responseBodyAsString,
                    'decodedResponse' => $result,
                ]
            );
            if ($response->getStatusCode() === StatusCodeInterface::STATUS_TOO_MANY_REQUESTS) {
                $problem = ApiProblem::fromJson(json_encode($result));
                throw new Exceptions\TooManyRequestsException(
                    $problem,
                    $problem->getTitle(),
                    $exception->getCode(),
                    $exception
                );
            }

            if (array_key_exists('result', $result)) {
                $problem = ApiProblem::fromJson(json_encode($result['result']));
                throw new Exceptions\ApiClientException($problem, $problem->getTitle(), $exception->getCode(), $exception);
            }
            throw new Exceptions\UnknownException('unknown api-server error', $exception->getCode(), $exception);
        } catch (GuzzleHttp\Exception\GuzzleException $exception) {
            // network error
            $this->log->error(
                'b24io.loyalty.sdk.apiClient.network.error',
                [
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new Exceptions\NetworkException($exception->getMessage(), $exception->getCode());
        } catch (Exceptions\TransportFormatException $exception) {
            // json format error
            $this->log->error(
                'b24io.loyalty.sdk.apiClient.transportFormat.error',
                [
                    'code'    => $exception->getCode(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw $exception;
        } catch (\Throwable $unhandledException) {
            // unknown error
            $this->log->error(
                'b24io.loyalty.sdk.apiClient.unknown.error',
                [
                    'type'    => \get_class($unhandledException),
                    'code'    => $unhandledException->getCode(),
                    'message' => $unhandledException->getMessage(),
                    'trace'   => $unhandledException->getTrace(),
                ]
            );
            throw new Exceptions\UnknownException('unknown error: ' . $unhandledException->getMessage(), $unhandledException->getCode());
        }
        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.executeRequest.finish',
            [
                'request_type'    => $requestType,
                'url'             => $url,
                'request_options' => $requestOptions,
                'http_status'     => $obResponse->getStatusCode(),
                'result'          => $result,
            ]
        );

        return $obResponse;
    }

    /**
     * @param string $jsonApiResponse
     *
     * @return mixed
     * @throws Exceptions\TransportFormatException
     */
    protected function decodeApiJsonResponse(string $jsonApiResponse)
    {
        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.decodeApiJsonResponse.start',
            [
                'response' => $jsonApiResponse,
            ]
        );
        if ($jsonApiResponse === '') {
            $errorMsg = \sprintf('empty response');
            $this->log->error($errorMsg);
            throw new Exceptions\TransportFormatException($errorMsg);
        }
        $jsonResult = \json_decode($jsonApiResponse, true);
        $jsonErrorCode = \json_last_error();
        if (null === $jsonResult && (JSON_ERROR_NONE !== $jsonErrorCode)) {
            $errorMsg = sprintf(
                'json_decode, error_code: %s, error_description: %s',
                $jsonErrorCode,
                \json_last_error_msg()
            );
            $this->log->error(
                'b24io.loyalty.sdk.apiClient.decodeApiJsonResponse.error',
                [
                    'message'      => $errorMsg,
                    'responseBody' => $jsonApiResponse,
                ]
            );

            throw new Exceptions\TransportFormatException($errorMsg);
        }
        $this->log->debug('b24io.loyalty.sdk.apiClient.decodeApiJsonResponse.finish');

        return $jsonResult;
    }

    /**
     * @param array $response
     * @param int   $serverStatusCode
     *
     * @throws Exceptions\UnknownException
     */
    protected function handleApiLevelErrors(array $response, int $serverStatusCode): void
    {
        $this->log->debug(
            'b24io.loyalty.sdk.apiClient.handleApiLevelErrors.start',
            [
                'response'     => $response,
                'serverStatus' => $serverStatusCode,
            ]
        );
        switch ($serverStatusCode) {
            case StatusCodeInterface::STATUS_OK:
            case StatusCodeInterface::STATUS_ACCEPTED:
                break;
            default:
                throw new Exceptions\UnknownException('api-level-error');
                break;
        }
        $this->log->debug('b24io.loyalty.sdk.apiClient.handleApiLevelErrors.finish');
    }

    /**
     * @param GuzzleHttp\HandlerStack $guzzleHandlerStack
     *
     * @return ApiClient
     */
    public function setGuzzleHandlerStack(GuzzleHttp\HandlerStack $guzzleHandlerStack): ApiClient
    {
        $this->log->debug('b24io.loyalty.sdk.apiClient.setGuzzleHandlerStack.start');
        $this->guzzleHandlerStack = $guzzleHandlerStack;
        $this->log->debug('b24io.loyalty.sdk.apiClient.setGuzzleHandlerStack.finish');

        return $this;
    }
}