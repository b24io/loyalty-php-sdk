<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport;

use B24io\Loyalty\SDK;
use Psr\Log\LoggerInterface;

/**
 * Class AbstractTransport
 *
 * @package B24io\Loyalty\SDK\Transport
 */
abstract class AbstractTransport
{
    /**
     * @var SDK\ApiClient
     */
    protected $apiClient;
    /**
     * @var LoggerInterface
     */
    protected $log;

    /**
     * AbstractTransport constructor.
     *
     * @param SDK\ApiClient   $apiClient
     * @param LoggerInterface $log
     */
    public function __construct(SDK\ApiClient $apiClient, LoggerInterface $log)
    {
        $this->apiClient = $apiClient;
        $this->log = $log;
    }

    /**
     * @param array $arMeta
     *
     * @return DTO\Metadata
     */
    protected function initMetadata(array $arMeta): SDK\Transport\DTO\Metadata
    {
        $meta = new SDK\Transport\DTO\Metadata();
        $meta
            ->setDuration($arMeta['duration'])
            ->setMessage($arMeta['message'])
            ->setRole(SDK\Transport\DTO\Role::initializeByCode($arMeta['role']));

        return $meta;
    }
}