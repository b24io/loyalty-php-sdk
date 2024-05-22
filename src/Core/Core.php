<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core;

use B24io\Loyalty\SDK\Core\Contracts\ApiClientInterface;
use B24io\Loyalty\SDK\Core\Contracts\CoreInterface;
use B24io\Loyalty\SDK\Core\Credentials\Context;
use B24io\Loyalty\SDK\Core\Exceptions\AuthForbiddenException;
use B24io\Loyalty\SDK\Core\Exceptions\BadRequestException;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Core\Exceptions\InternalServerErrorException;
use B24io\Loyalty\SDK\Core\Exceptions\MethodNotFoundException;
use B24io\Loyalty\SDK\Core\Exceptions\TransportException;
use B24io\Loyalty\SDK\Core\Response\ApiProblem;
use B24io\Loyalty\SDK\Core\Response\Response;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Core implements CoreInterface
{
    public function __construct(
        protected ApiClientInterface $apiClient,
        protected LoggerInterface    $logger)
    {
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
                'order' => [
                    'orderBy' => $cmd->itemsOrder?->orderBy,
                    'direction' => $cmd->itemsOrder?->direction,
                ],
            ]
        );

        try {
            // make async request
            $apiCallResponse = $this->apiClient->getResponse(
                $cmd->context,
                $cmd->httpMethod,
                $cmd->apiMethod,
                $cmd->parameters,
                $cmd->itemsOrder,
                $cmd->page,
                $cmd->idempotencyKey
            );

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
                case StatusCodeInterface::STATUS_BAD_REQUEST:
                    $this->logger->error(
                        'bad request',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId->toRfc4122(),
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                            'parameters' => $cmd->parameters,
                            'response' => $apiCallResponse->toArray(false),
                        ]
                    );
                    $responseResult = $apiCallResponse->toArray(false);
                    $apiProblem = ApiProblem::fromArray($responseResult['error']);
                    throw new BadRequestException(
                        $apiProblem,
                        sprintf('bad request «%s» on api call «%s» for client %s',
                            $apiProblem->detail,
                            $cmd->apiMethod,
                            $this->apiClient->getCredentials()->clientId->toRfc4122())
                    );
                case StatusCodeInterface::STATUS_FORBIDDEN:
                    $this->logger->warning(
                        'authorisation forbidden',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId->toRfc4122(),
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                        ]
                    );
                    throw new AuthForbiddenException(sprintf('authorisation forbidden for client %s ',
                        $this->apiClient->getCredentials()->clientId->toRfc4122()));
                case StatusCodeInterface::STATUS_NOT_FOUND:
                    $this->logger->error(
                        'method or entity not found',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId->toRfc4122(),
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                        ]
                    );
                    throw new MethodNotFoundException(sprintf('method %s not found', $cmd->apiMethod));
                case StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR:
                    $this->logger->error(
                        'internal server error',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId->toRfc4122(),
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                            'parameters' => $cmd->parameters,
                            'response' => $apiCallResponse->toArray(false),
                        ]
                    );
                    $responseResult = $apiCallResponse->toArray(false);
                    $apiProblem = ApiProblem::fromArray($responseResult['error']);
                    throw new InternalServerErrorException(
                        $apiProblem,
                        sprintf('internal server error «%s» on api call «%s» for client %s',
                            $apiProblem->detail,
                            $cmd->apiMethod,
                            $this->apiClient->getCredentials()->clientId->toRfc4122())
                    );
                case StatusCodeInterface::STATUS_SERVICE_UNAVAILABLE:
                    $this->logger->error(
                        'server unavailable error',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId->toRfc4122(),
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                            'parameters' => $cmd->parameters,
                            'response' => $apiCallResponse->toArray(false),
                        ]
                    );
                    $responseResult = $apiCallResponse->toArray(false);
                    $apiProblem = ApiProblem::fromArray($responseResult['error']);
                    throw new InternalServerErrorException(
                        $apiProblem,
                        sprintf('server unavailable error «%s» on api call «%s» for client %s',
                            $apiProblem->detail,
                            $cmd->apiMethod,
                            $this->apiClient->getCredentials()->clientId->toRfc4122())
                    );
                default:
                    $this->logger->error(
                        'unhandled server status',
                        [
                            'clientId' => $this->apiClient->getCredentials()->clientId->toRfc4122(),
                            'domainUrl' => $this->apiClient->getCredentials()->domainUrl,
                            'apiMethod' => $cmd->apiMethod,
                            'parameters' => $cmd->parameters,
                            'response' => $apiCallResponse->toArray(false),
                        ]
                    );
                    $responseResult = $apiCallResponse->toArray(false);
                    $apiProblem = ApiProblem::fromArray($responseResult['error']);
                    throw new InternalServerErrorException(
                        $apiProblem,
                        sprintf('unhandled server status error «%s» on api call «%s» for client %s',
                            $apiProblem->detail,
                            $cmd->apiMethod,
                            $this->apiClient->getCredentials()->clientId->toRfc4122())
                    );
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
        } catch (BadRequestException|BaseException $exception) {
            // rethrow known php sdk exception
            throw $exception;
        } catch (\Throwable $exception) {
            $this->logger->error(
                'call.unknownException',
                [
                    'message' => $exception->getMessage(),
                    'exceptionType' => $exception::class,
                    'trace' => $exception->getTrace(),
                ]
            );
            throw new BaseException(sprintf('unknown error - %s', $exception->getMessage()), $exception->getCode(), $exception);
        }
        $this->logger->debug('call.finish');

        return $response;
    }
}