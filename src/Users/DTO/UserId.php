<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Users\DTO;

/**
 * Class UserId
 *
 * @package B24io\Loyalty\SDK\Users\DTO
 */
final class UserId
{
    /**
     * @var int
     */
    private $id;

    /**
     * UserId constructor.
     *
     * @param int $userId
     */
    public function __construct(int $userId)
    {
        $this->id = $userId;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}