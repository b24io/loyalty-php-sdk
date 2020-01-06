<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class Role
 * @method admin();
 * @method user();
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
class Role extends AbstractEnumeration
{
    public const admin = 'admin';
    public const user = 'user';

    /**
     * Admin role?
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->key() === self::admin;
    }

    /**
     * User role?
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this->key() === self::user;
    }

    /**
     * @param string $roleCode
     *
     * @return $this
     */
    public static function initializeByCode(string $roleCode): self
    {
        return self::memberByValue($roleCode);
    }
}