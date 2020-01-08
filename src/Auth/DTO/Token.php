<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Auth\DTO;

use B24io\Loyalty\SDK\Transport\DTO\Role;
use Ramsey\Uuid\UuidInterface;

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
     * @var UuidInterface
     */
    private $clientApiKey;
    /**
     * @var UuidInterface
     */
    private $authApiKey;

    /**
     * Token constructor.
     *
     * @param Role          $role
     * @param UuidInterface $clientApiKey
     * @param UuidInterface $authApiKey
     */
    public function __construct(Role $role, UuidInterface $clientApiKey, UuidInterface $authApiKey)
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
     * @return UuidInterface
     */
    public function getClientApiKey(): UuidInterface
    {
        return $this->clientApiKey;
    }

    /**
     * @return UuidInterface
     */
    public function getAuthApiKey(): UuidInterface
    {
        return $this->authApiKey;
    }
}