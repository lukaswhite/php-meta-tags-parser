<?php

namespace Lukaswhite\MetaTagsParser;

/**
 * Class Feed
 *
 * @package Lukaswhite\MetaTagsParser
 */
class Feed
{
    const RSS = 'rss';
    const ATOM = 'atom';

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $uri;

    /**
     * @var string
     */
    protected $title;

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return bool
     */
    public function isRSS(): bool
    {
        return $this->type === self::RSS;
    }

    /**
     * @return bool
     */
    public function isAtom(): bool
    {
        return $this->type === self::ATOM;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return self
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Convert the result into an array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type'              =>  $this->getType(),
            'uri'               =>  $this->getUri(),
            'title'             =>  $this->getTitle(),
        ];
    }

}