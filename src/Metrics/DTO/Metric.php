<?php

declare(strict_types=1);

namespace B24io\Loyalty\SDK\Metrics\DTO;

use Ramsey\Uuid\UuidInterface;

/**
 * Class Metric
 *
 * @package B24io\Loyalty\SDK\Metrics\DTO
 */
final class Metric
{
    /**
     * @var UuidInterface
     */
    private $uuid;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var MetricCode
     */
    private $code;
    /**
     * @var MetricType
     */
    private $type;
    /**
     * @var \DateTime
     */
    private $created;

    /**
     * Metric constructor.
     *
     * @param UuidInterface $uuid
     * @param string        $name
     * @param string        $description
     * @param MetricCode    $code
     * @param MetricType    $type
     * @param \DateTime     $created
     */
    public function __construct(
        UuidInterface $uuid,
        string $name,
        string $description,
        MetricCode $code,
        MetricType $type,
        \DateTime $created
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->description = $description;
        $this->code = $code;
        $this->type = $type;
        $this->created = $created;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return MetricCode
     */
    public function getCode(): MetricCode
    {
        return $this->code;
    }

    /**
     * @return MetricType
     */
    public function getType(): MetricType
    {
        return $this->type;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }
}