<?php

namespace Lukaswhite\MetaTagsParser;

/**
 * Trait HasTitleAndDescription
 *
 * @package Lukaswhite\MetaTagsParser
 */
trait HasTitleAndDescription
{
    /**
     * The page title
     *
     * @var string
     */
    protected $title;

    /**
     * The page description
     *
     * @var string
     */
    protected $description;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}