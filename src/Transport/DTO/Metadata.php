<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

/**
 * Class Metadata
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
final class Metadata
{
    /**
     * @var float
     */
    private $duration;
    /**
     * @var string
     */
    private $message;

    /**
     * @var Role
     */
    private $role;

    /**
     * @return float
     */
    public function getDuration(): float
    {
        return $this->duration;
    }

    /**
     * @param float $duration
     *
     * @return Metadata
     */
    public function setDuration(float $duration): Metadata
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return Metadata
     */
    public function setMessage(string $message): Metadata
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Role
     */
    public function getRole(): Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     *
     * @return Metadata
     */
    public function setRole(Role $role): Metadata
    {
        $this->role = $role;

        return $this;
    }
}