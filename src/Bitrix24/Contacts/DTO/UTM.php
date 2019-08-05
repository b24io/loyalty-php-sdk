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
     * @var string|null
     */
    protected $campaign;
    /**
     * @var string|null
     */
    protected $content;
    /**
     * @var string|null
     */
    protected $medium;
    /**
     * @var string|null
     */
    protected $source;
    /**
     * @var string|null
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
    public function __construct(?string $source, ?string $medium, ?string $campaign, ?string $term, ?string $content)
    {
        $this->setSource($source);
        $this->setMedium($medium);
        $this->setCampaign($campaign);
        $this->setTerm($term);
        $this->setContent($content);
    }

    /**
     * @param string|null $campaign
     *
     * @return UTM
     */
    protected function setCampaign(?string $campaign): UTM
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * @param string|null $content
     *
     * @return UTM
     */
    protected function setContent(?string $content): UTM
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @param string|null $medium
     *
     * @return UTM
     */
    protected function setMedium(?string $medium): UTM
    {
        $this->medium = $medium;

        return $this;
    }

    /**
     * @param string|null $source
     *
     * @return UTM
     */
    protected function setSource(?string $source): UTM
    {
        $this->source = $source;

        return $this;
    }

    /**
     * @param string|null $term
     *
     * @return UTM
     */
    protected function setTerm(?string $term): UTM
    {
        $this->term = $term;

        return $this;
    }

    /**
     * @param array $arUtm
     *
     * @return UTM
     */
    public static function initFromArray(array $arUtm): self
    {
        return new self(
            $arUtm['utm_source'],
            $arUtm['utm_medium'],
            $arUtm['utm_campaign'],
            $arUtm['utm_term'],
            $arUtm['utm_content']);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'utm_source' => $this->getSource(),
            'utm_medium' => $this->getMedium(),
            'utm_campaign' => $this->getCampaign(),
            'utm_term' => $this->getTerm(),
            'utm_content' => $this->getContent(),
        ];
    }

    /**
     * @return string|null
     */
    public function getCampaign(): ?string
    {
        return $this->campaign;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @return string|null
     */
    public function getMedium(): ?string
    {
        return $this->medium;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return string|null
     */
    public function getTerm(): ?string
    {
        return $this->term;
    }
}