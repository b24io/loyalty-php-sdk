<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Settings\Transport\Admin;

use B24io\Loyalty\SDK;

use Fig\Http\Message\RequestMethodInterface;

/**
 * Class Transport
 *
 * @package B24io\Loyalty\SDK\Settings\Transport\Admin
 */
class Transport extends SDK\Transport\AbstractTransport
{
    /**
     * @return SDK\Settings\Transport\DTO\SettingsResponse
     * @throws SDK\Exceptions\ApiClientException
     * @throws SDK\Exceptions\NetworkException
     * @throws SDK\Exceptions\UnknownException
     */
    public function getApplicationSettings(): SDK\Settings\Transport\DTO\SettingsResponse
    {
        $this->log->debug('b24io.loyalty.sdk.settings.transport.admin.getApplicationSettings.start');

        $requestResult = $this->apiClient->executeApiRequest(
            'admin/settings/application',
            RequestMethodInterface::METHOD_GET);

        $settingsResponse = new SDK\Settings\Transport\DTO\SettingsResponse(
            $this->initMetadata($requestResult['meta']),
            SDK\Settings\DTO\Fabric::initSettingsFromArray($requestResult['result'])
        );

        $this->log->debug('b24io.loyalty.sdk.settings.transport.admin.getApplicationSettings.finish', [
            'metadata' => SDK\Transport\Formatters\Metadata::toArray($settingsResponse->getMeta()),
        ]);

        return $settingsResponse;
    }
}