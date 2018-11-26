<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Auth\DTO;

use B24io\Loyalty\SDK\Transport\DTO\Role;

/**
 * Class Token
 *
 * @package B24io\Loyalty\SDK\Auth\DTO
 */
final class Token
{
    /**
     * @var Role
     */
    private $role;
    /**
     * @var string
     */
    private $clientApiKey;
    /**
     * @var string
     */
    private $authApiKey;

    /**
     * Token constructor.
     *
     * @param Role   $role
     * @param string $clientApiKey
     * @param string $authApiKey
     */
    public function __construct(Role $role, string $clientApiKey, string $authApiKey)
    {
        $this->role = $role;
        $this->clientApiKey = $clientApiKey;
        $this->authApiKey = $authApiKey;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getClientApiKey(): string
    {
        return $this->clientApiKey;
    }

    /**
     * @return string
     */
    public function getAuthApiKey(): string
    {
        return $this->authApiKey;
    }
}