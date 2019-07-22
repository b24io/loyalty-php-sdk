<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Users\DTO;

/**
 * Class Email
 */
final class Email
{
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $domain;

    /**
     * Email constructor.
     *
     * @param $email
     */
    public function __construct(string $email)
    {
        $this->username = implode(explode('@', $email, -1), '@');
        $this->domain = str_replace($this->username . '@', '', $email);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->username . '@' . $this->domain;
    }

    /**
     * Get username of email address.
     *
     * @return string username of email address.
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get domain of email address.
     *
     * @return string Domain of email address.
     */
    public function getDomain(): string
    {
        return $this->domain;
    }
}