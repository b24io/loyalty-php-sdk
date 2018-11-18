<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Cards\DTO\Statuses;

use B24io\Loyalty\SDK\Exceptions\BaseLoyaltyException;

/**
 * Class Fabric
 *
 * @package B24io\Loyalty\SDK\Cards\DTO\Statuses
 */
class Fabric
{
    /**
     * @param string $statusCode
     *
     * @return StatusInterface
     * @throws BaseLoyaltyException
     */
    public static function initByStatusCode(string $statusCode): StatusInterface
    {
        switch ($statusCode) {
            case 'active':
                return self::getActive();
                break;
            case 'blocked':
                return self::getBlocked();
                break;
            case 'deleted':
                return self::getDeleted();
                break;
            default:
                throw new BaseLoyaltyException(sprintf('unknown card status code [%s]', $statusCode));
                break;
        }
    }

    /**
     * @return StatusInterface
     */
    public static function getActive(): StatusInterface
    {
        return new Active('active');
    }

    /**
     * @return StatusInterface
     */
    public static function getBlocked(): StatusInterface
    {
        return new Blocked('blocked');
    }

    /**
     * @return StatusInterface
     */
    public static function getDeleted(): StatusInterface
    {
        return new Deleted('deleted');
    }
}