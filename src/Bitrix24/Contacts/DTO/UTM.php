<?php
declare(strict_types=1);

namespace B24io\Loyalty\SDK\Bitrix24\Contacts\DTO;

/**
 * Class UTM
 *
 * @package B24io\Loyalty\SDK\Bitrix24\Contacts\DTO
 */
class UTM
{
    /**
     * @var string
     */
    protected $campaign;
    /**
     * @var string
     */
    protected $content;
    /**
     * @var string
     */
    protected $medium;
    /**
     * @var string
     */
    protected $source;
    /**
     * @var string
     */
    protected $term;

    /**
     * UTM constructor.
     *
     * @param string $campaign
     * @param string $content
     * @param string $medium
     * @param string $source
     * @param string $term
     */
    public function __construct(string $campaign, string $content, string $medium, string $source, string $term)
    {
        $this->setCampaign($campaign);
        $this->setContent($content);
        $this->setMedium($medium);
        $this->setSource($source);
        $this->setTerm($term);
    }

    /**
     * @return string
     */
    public function getCampaign(): string
    {
        return $this->campaign;
    }

    /**
     * @param string $campaign
     *
     * @return UTM
     */
    public function setCampaign(string $campaign): UTM
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return UTM
     */
    public function setContent(string $content): UTM
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getMedium(): string
    {
        return $this->medium;
    }

    /**
     * @param string $medium
     *
     * @return UTM
     */
    public function setMedium(string $medium): UTM
    {
        $this->medium = $medium;

        return $this;
    }

    /**
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * @param string $source
     *
     * @return UTM
     */
    public function setSource(string $source): UTM
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @return string
     */
    public function getTerm(): string
    {
        return $this->term;
    }

    /**
     * @param string $term
     *
     * @return UTM
     */
    public function setTerm(string $term): UTM
    {
        $this->term = $term;

        return $this;
    }
}