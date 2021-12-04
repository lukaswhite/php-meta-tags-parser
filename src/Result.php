<?php

namespace Lukaswhite\MetaTagsParser;

/**
 * Class Result
 *
 * @package Lukaswhite\MetaTagsParser
 */
class Result
{
    use HasTitleAndDescription;

    /**
     * The site's URL, as it appears - if present - in the meta tags.
     *
     * @var string
     */
    protected $url;

    /**
     * The Open Graph data
     *
     * @var OpenGraph
     */
    protected $openGraph;

    /**
     * The keywords
     *
     * @var array
     */
    protected $keywords = [];

    /**
     * The Facebook app ID
     *
     * @var string
     */
    protected $facebookAppId;

    /**
     * RSS/Atom feeds
     *
     * @var array
     */
    protected $feeds = [];

    /**
     * Result constructor.
     */
    public function __construct()
    {
        $this->openGraph = new OpenGraph( );
    }

    /**
     * @return string
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * Get the Open Graph data
     *
     * @return OpenGraph
     */
    public function openGraph(): OpenGraph
    {
        return $this->openGraph;
    }

    /**
     * Get the keywords
     *
     * @return array
     */
    public function getKeywords(): array
    {
        return $this->keywords;
    }

    /**
     * Set the keywords
     *
     * @param $keywords
     * @return $this
     */
    public function setKeywords($keywords): self
    {
        if (is_string($keywords)) {
            $keywords = array_map(
                function($keyword) {
                    return trim($keyword);
                },
                explode( ',', $keywords )
            );
        }

        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookAppId(): ?string
    {
        return $this->facebookAppId;
    }

    /**
     * @param string $facebookAppId
     * @return Result
     */
    public function setFacebookAppId($facebookAppId): self
    {
        $this->facebookAppId = $facebookAppId;
        return $this;
    }

    /**
     * @param Feed $feed
     * @return $this
     */
    public function addFeed(Feed $feed): self
    {
        $this->feeds[] = $feed;
        return $this;
    }

    /**
     * @param string $type
     * @return array
     */
    public function getFeeds(string $type = null): array
    {
        return $type ? array_filter($this->feeds, function(Feed $feed) use ($type) {
            return $feed->getType() === $type;
        }) : $this->feeds;
    }

    /**
     * Convert the result into an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title'             =>  $this->getTitle(),
            'description'       =>  $this->getDescription(),
            'keywords'          =>  $this->getKeywords(),
            'url'               =>  $this->getUrl(),
            'og'                =>  $this->openGraph()->toArray(),
            'feeds'             =>  array_map(
                function(Feed $feed) {
                    return $feed->toArray();
                },
                $this->feeds
            )
        ];
    }

}