<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

use Eloquent\Enumeration;

/**
 * Class Role
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
class Role extends Enumeration\AbstractMultiton
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var string
     */
    private $description;

    /**
     * Role constructor.
     *
     * @param        $key
     * @param string $code
     * @param string $description
     */
    protected function __construct($key, string $code, string $description)
    {
        parent::__construct($key);

        $this->code = $code;
        $this->description = $description;
    }

    /**
     * @param string $code
     *
     * @return static
     * @throws \Eloquent\Enumeration\Exception\UndefinedMemberExceptionInterface
     */
    public static function initializeByCode(string $code)
    {
        return static::memberByPredicate(function (Enumeration\MultitonInterface $member) use ($code) {
            return $member->getCode() === $code;
        });
    }

    /**
     * {@inheritdoc}
     * @throws \Eloquent\Enumeration\Exception\ExtendsConcreteException
     */
    protected static function initializeMembers(): void
    {
        new self('admin', 'admin', 'admin role');
        new self('user', 'user', 'user role');
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Admin role?
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this === self::admin();
    }

    /**
     * User role?
     *
     * @return bool
     */
    public function isUser(): bool
    {
        return $this === self::user();
    }
}