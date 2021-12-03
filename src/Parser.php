<?php

namespace Lukaswhite\MetaTagsParser;

use voku\helper\HtmlDomParser;

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
            $result->setTitle($title->text);
        }

        $metaTags = $dom->findMulti('meta');

        foreach($metaTags as $tag)
        {
            $name = $tag->getAttribute('name') ? $tag->getAttribute('name') : $tag->getAttribute('property');

            switch ($name) {
                case 'description':
                    $result->setDescription($tag->getAttribute('content'));
                    break;
                case 'keywords':
                    $result->setKeywords($tag->getAttribute('content'));
                    break;
                case 'og:site_name':
                    $result->openGraph()->setSiteName($tag->getAttribute('content'));
                    break;
                case 'og:title':
                    $result->openGraph()->setTitle($tag->getAttribute('content'));
                    break;
                case 'og:description':
                    $result->openGraph()->setDescription($tag->getAttribute('content'));
                    break;
                case 'og:image':
                case 'og:secure_image':
                    $result->openGraph()->addImage($tag->getAttribute('content'));
                    break;
                case 'og:type':
                    $result->openGraph()->setType($tag->getAttribute('content'));
                    break;
                case 'og:url':
                    $result->openGraph()->setUrl($tag->getAttribute('content'));
                    break;
                case 'og:locale':
                    $result->openGraph()->setLocale($tag->getAttribute('content'));
                    break;
                case 'og:latitude':
                    $result->openGraph()->setLatitude(floatval($tag->getAttribute('content')));
                    break;
                case 'og:longitude':
                    $result->openGraph()->setLongitude(floatval($tag->getAttribute('content')));
                    break;
                case 'og:altitude':
                    $result->openGraph()->setAltitude(intval($tag->getAttribute('content')));
                    break;
                case 'fb:app_id':
                    $result->setFacebookAppId($tag->getAttribute('content'));
                    break;
            }
        }

        return $result;

    }

}