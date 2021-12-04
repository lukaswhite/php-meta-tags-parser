<?php

namespace Lukaswhite\MetaTagsParser;

use Lukaswhite\MetaTagsParser\Cleanser\Cleanser;
use Lukaswhite\MetaTagsParser\Cleanser\CleansesStrings;
use Lukaswhite\MetaTagsParser\Sanitizer\Sanitizer;
use Lukaswhite\MetaTagsParser\Sanitizer\SanitizesStrings;
use voku\helper\HtmlDomParser;
use voku\helper\SimpleHtmlDom;

/**
 * Class Parser
 *
 * Parses HTML and extracts the contents of the meta tags; e.g. title, description,
 * and Open Graph data.
 *
 * @package Lukaswhite\MetaTagsParser
 */
class Parser
{
    /**
     * @var CleansesStrings
     */
    protected $cleanser;

    /**
     * @var SanitizesStrings
     */
    protected $sanitizer;

    /**
     * Parser constructor.
     *
     * The package provides very simple methods for cleansing and sanitizing strings;
     * if you wish to override them, it's as simple as passing them into the constructor.
     *
     * @param CleansesStrings|null $cleanser
     * @param SanitizesStrings|null $sanitizer
     */
    public function __construct(CleansesStrings $cleanser = null, SanitizesStrings $sanitizer = null)
    {
        $this->cleanser = $cleanser ?? new Cleanser();
        $this->sanitizer = $sanitizer ?? new Sanitizer();
    }

    /**
     * Parse the provided HTML, and extract the metadata
     *
     * @param string $html
     * @return Result
     */
    public function parse(string $html) : Result
    {
        $result = new Result();

        $dom = HtmlDomParser::str_get_html($html);

        $title = $dom->findOne('title');

        if ($title) {
            $result->setTitle($this->cleanser->run($this->sanitizer->run($title->text)));
        }

        $metaTags = $dom->findMulti('meta');

        foreach($metaTags as $tag)
        {
            $name = $tag->getAttribute('name') ? $tag->getAttribute('name') : $tag->getAttribute('property');

            switch ($name) {
                case 'description':
                    $result->setDescription($this->getTagAttribute($tag));
                    break;
                case 'keywords':
                    $result->setKeywords($this->getTagAttribute($tag));
                    break;
                case 'og:site_name':
                    $result->openGraph()->setSiteName($this->getTagAttribute($tag));
                    break;
                case 'og:title':
                    $result->openGraph()->setTitle($this->getTagAttribute($tag));
                    break;
                case 'og:description':
                    $result->openGraph()->setDescription($this->getTagAttribute($tag));
                    break;
                case 'og:image':
                case 'og:secure_image':
                    $result->openGraph()->addImage($this->getTagAttribute($tag));
                    break;
                case 'og:type':
                    $result->openGraph()->setType($this->getTagAttribute($tag));
                    break;
                case 'og:url':
                    $result->openGraph()->setUrl($this->getTagAttribute($tag));
                    break;
                case 'og:locale':
                    $result->openGraph()->setLocale($this->getTagAttribute($tag));
                    break;
                case 'og:latitude':
                    $result->openGraph()->setLatitude(floatval($this->getTagAttribute($tag)));
                    break;
                case 'og:longitude':
                    $result->openGraph()->setLongitude(floatval($this->getTagAttribute($tag)));
                    break;
                case 'og:altitude':
                    $result->openGraph()->setAltitude(intval($this->getTagAttribute($tag)));
                    break;
                case 'fb:app_id':
                    $result->setFacebookAppId($this->getTagAttribute($tag));
                    break;
            }
        }

        return $result;

    }

    /**
     * @param SimpleHtmlDom $tag
     * @param string $name
     * @return string
     */
    protected function getTagAttribute(SimpleHtmlDom $tag, string $name = 'content')
    {
        return $this->cleanser->run(
            $this->sanitizer->run($tag->getAttribute($name))
        );
    }

}