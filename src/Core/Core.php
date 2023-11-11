<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core;

use B24io\Loyalty\SDK\Core\Contracts\ApiClientInterface;
use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Exceptions\AuthForbiddenException;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Core\Exceptions\MethodNotFoundException;
use B24io\Loyalty\SDK\Core\Exceptions\TransportException;
use B24io\Loyalty\SDK\Core\Response\Response;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Core implements CoreInterface
{
    protected ApiClientInterface $apiClient;
    protected LoggerInterface $logger;

    public function __construct(
        ApiClientInterface $apiClient,
        LoggerInterface    $logger
    )
    {
        $this->apiClient = $apiClient;
        $this->logger = $logger;
    }

    /**
     * @throws TransportException
     * @throws BaseException
     * @throws AuthForbiddenException
     */
    public function call(Command $cmd): Response
    {
        $this->logger->debug(
            'call.start',
            [
                'httpMethod' => $cmd->httpMethod,
                'apiMethod' => $cmd->apiMethod,
                'parameters' => $cmd->parameters,
            ]
        );

        $response = null;
        try {
            // make async request
            $apiCallResponse = $this->apiClient->getResponse(
                $cmd->context,
                $cmd->httpMethod,
                $cmd->apiMethod,
                $cmd->parameters,
                $cmd->page);

            $this->logger->debug(
                'call.responseInfo',
                [
                    'httpStatus' => $apiCallResponse->getStatusCode(),
                ]
            );
            switch ($apiCallResponse->getStatusCode()) {
                case StatusCodeInterface::STATUS_OK:
                    //todo check with empty response size from server
                    $response = new Response($apiCallResponse,
                        new Command(
                            Context::admin,
                            $cmd->httpMethod,
                            $cmd->apiMethod,
                            $cmd->parameters
                        ),
                        $this->logger);
                    break;
                case StatusCodeInterface::STATUS_FORBIDDEN:
                    $this->logger->warning(
                        'authorisation forbidden',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId,
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                        ]
                    );
                    throw new AuthForbiddenException(sprintf('authorisation forbidden for client %s ',
                        $this->apiClient->getCredentials()->clientId->toRfc4122()));
                case StatusCodeInterface::STATUS_NOT_FOUND:
                    $this->logger->error(
                        'method not found',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId,
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                        ]
                    );
                    throw new MethodNotFoundException(sprintf('method %s not found', $cmd->apiMethod));
                case StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->notice(
                        'unavailable',
                        [
                            'body' => $body,
                        ]
                    );
                    break;
                default:
                    $body = $apiCallResponse->toArray(false);
                    $this->logger->error(
                        'unhandled server status',
                        [
                            'httpStatus' => $apiCallResponse->getStatusCode(),
                            'body' => $body,
                        ]
                    );
                    break;
            }
        } catch (TransportExceptionInterface $exception) {
            // catch symfony http client transport exception
            $this->logger->error(
                'call.transportException',
                [
                    'trace' => $exception->getTrace(),
                    'message' => $exception->getMessage(),
                ]
            );
            throw new TransportException(sprintf('transport error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        } catch (BaseException $exception) {
            // rethrow known php sdk exception
            throw $exception;
        } catch (\Throwable $exception) {
            $this->logger->error(
                'call.unknownException',
                [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTrace(),
                ]
            );
            throw new BaseException(sprintf('unknown error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        }
        $this->logger->debug('call.finish');

        return $response;
    }
}