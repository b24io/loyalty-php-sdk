<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport;

/**
 * Interface DefaultRequestArgumentsInterface
 *
 * @package B24io\Loyalty\SDK\Transport
 */
interface DefaultRequestArgumentsInterface
{
    public const DATE_FROM = 'date_from';
    public const DATE_TO = 'date_to';
    public const CLIENT_API_KEY = 'loyalty_client_api_key';
}