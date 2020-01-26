<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\SystemJournal\DTO;

use Ramsey\Uuid\UuidInterface;

/**
 * Class JournalItem
 *
 * @package B24io\Loyalty\SDK\SystemJournal\DTO
 */
class JournalItem
{
    /**
     * @var \DateTime
     */
    private $timestamp;
    /**
     * @var LogLevel
     */
    private $level;
    /**
     * @var string
     */
    private $message;
    /**
     * @var string
     */
    private $source;
    /**
     * @var UuidInterface
     */
    private $eventUuid;

    /**
     * JournalItem constructor.
     *
     * @param \DateTime     $timestamp
     * @param LogLevel      $level
     * @param string        $message
     * @param string        $source
     * @param UuidInterface $eventUuid
     */
    public function __construct(\DateTime $timestamp, LogLevel $level, string $message, string $source, UuidInterface $eventUuid)
    {
        $this->timestamp = $timestamp;
        $this->level = $level;
        $this->message = $message;
        $this->source = $source;
        $this->eventUuid = $eventUuid;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp(): \DateTime
    {
        return $this->timestamp;
    }

    /**
     * @return LogLevel
     */
    public function getLevel(): LogLevel
    {
        return $this->level;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @return UuidInterface
     */
    public function getEventUuid(): UuidInterface
    {
        return $this->eventUuid;
    }
}