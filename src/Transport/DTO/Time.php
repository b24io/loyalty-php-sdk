<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Transport\DTO;

/**
 * Class Time
 *
 * @package B24io\Loyalty\SDK\Transport\DTO
 */
final class Time
{
    /**
     * @var float
     */
    private $duration;
    /**
     * @var \DateTime
     */
    private $dateStart;
    /**
     * @var \DateTime
     */
    private $dateEnd;

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
     * @return Time
     */
    public function setDuration(float $duration): Time
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateStart(): \DateTime
    {
        return $this->dateStart;
    }

    /**
     * @param \DateTime $dateStart
     *
     * @return Time
     */
    public function setDateStart(\DateTime $dateStart): Time
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnd(): \DateTime
    {
        return $this->dateEnd;
    }

    /**
     * @param \DateTime $dateEnd
     *
     * @return Time
     */
    public function setDateEnd(\DateTime $dateEnd): Time
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }
}