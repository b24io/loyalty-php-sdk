<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Core\Response;

use B24io\Loyalty\SDK\Core\Command;
use B24io\Loyalty\SDK\Core\Exceptions\BaseException;
use B24io\Loyalty\SDK\Core\Exceptions\TransportException;
use B24io\Loyalty\SDK\Core\Response\DTO\Metadata;
use B24io\Loyalty\SDK\Core\Response\DTO\Pagination;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Throwable;

class Response
{
    public function __construct(
        public readonly ResponseInterface $httpResponse,
        public readonly Command           $apiCommand,
        private readonly LoggerInterface  $logger,
        private ?DTO\ResponseData         $responseData = null,
    )
    {
    }

    /**
     * @return DTO\ResponseData
     * @throws BaseException
     */
    public function getResponseData(): DTO\ResponseData
    {
        $this->logger->debug('getResponseData.start');

        if ($this->responseData === null) {
            try {
                $this->logger->debug('getResponseData.parseResponse.start');
                $responseResult = $this->httpResponse->toArray();

                $this->logger->info('getResponseData.responseBody', [
                    'responseBody' => $responseResult,
                ]);
                // fix health method data structure bug
                if (!array_key_exists('data', $responseResult)) {
                    $responseResult['data'] = $responseResult;
                }
                //todo try to handle api-level errors
                if (!is_array($responseResult['data'])) {
                    $responseResult['data'] = [$responseResult['data']];
                }
                if (!array_key_exists('pagination', $responseResult)) {
                    $responseResult['pagination'] = [];
                }

                $this->responseData = new DTO\ResponseData(
                    $responseResult['data'],
                    Metadata::initFromArray($responseResult['metadata']),
                    Pagination::initFromArray($responseResult['pagination'])
                );
                $this->logger->debug('getResponseData.parseResponse.finish');
            } catch (Throwable $exception) {
                $this->logger->error(
                    $exception->getMessage(),
                    [
                        'response' => $this->getHttpResponseContent(),
                    ]
                );
                throw new BaseException(sprintf('api request error: %s', $exception->getMessage()), $exception->getCode(), $exception);
            }
        }
        $this->logger->debug('getResponseData.finish');

        return $this->responseData;
    }

    /**
     * @return string|null
     */
    private function getHttpResponseContent(): ?string
    {
        $content = null;
        try {
            $content = $this->httpResponse->getContent(false);
        } catch (Throwable $exception) {
            $this->logger->error($exception->getMessage());
        }

        return $content;
    }
}