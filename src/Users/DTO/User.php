<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Users\DTO;

/**
 * Class User
 *
 * @package B24io\Loyalty\SDK\Users\DTO
 */
final class User
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @param UserId $userId
     *
     * @return User
     */
    public function setUserId(UserId $userId): User
    {
        $this->userId = $userId;

        return $this;
    }
}