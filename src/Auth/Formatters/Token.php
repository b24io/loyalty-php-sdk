<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Auth\Formatters;

use B24io\Loyalty\SDK;

/**
 * Class Token
 *
 * @package B24io\Loyalty\SDK\Auth\Formatters
 */
class Token
{
    /**
     * @param SDK\Auth\DTO\Token $token
     *
     * @return array
     */
    public static function toArray(SDK\Auth\DTO\Token $token): array
    {
        if ($token->getRole()->isAdmin()) {
            return [
                'X-LOYALTY-API-KEY-CLIENT' => $token->getClientApiKey()->toString(),
                'X-LOYALTY-API-KEY-ADMIN'  => $token->getAuthApiKey()->toString(),
            ];
        }

        return [
            'X-LOYALTY-API-KEY-CLIENT' => $token->getClientApiKey()->toString(),
            'X-LOYALTY-API-KEY-USER'   => $token->getAuthApiKey()->toString(),
        ];
    }
}