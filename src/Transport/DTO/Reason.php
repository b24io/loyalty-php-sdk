<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

/**
 * Class Reason
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
final class Reason
{
    /**
     * @var string reason code, required
     */
    private $code;

    /**
     * @var string|null operation id
     */
    private $id;
    /**
     * @var string|null operation comment
     */
    private $comment;

    /**
     * Reason constructor.
     *
     * @param string      $code
     * @param string|null $id
     * @param string|null $comment
     */
    public function __construct(string $code, string $id = null, string $comment = null)
    {
        $this->code = $code;
        $this->id = $id;
        $this->comment = $comment;
    }

    /**
     * @param array $arReason
     *
     * @return Reason
     */
    public static function initReasonFromArray(array $arReason): self
    {
        return new Reason($arReason['code'], $arReason['comment'], $arReason['id']);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return null|string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }
}