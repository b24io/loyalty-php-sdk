<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Users\DTO;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Users\DTO
 */
class Fabric
{
    /**
     * @param array $user
     *
     * @return User
     */
    public static function initFromArray(array $user): User
    {
        $newUser = new User();
        $newUser
            ->setUserId(new UserId((int)$user['user-id']));

        return $newUser;
    }
}