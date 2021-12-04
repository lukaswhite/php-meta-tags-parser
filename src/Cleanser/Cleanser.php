<?php


namespace Lukaswhite\MetaTagsParser\Cleanser;

/**
 * Class Cleanser
 *
 * @package Lukaswhite\MetaTagsParser\Cleanser
 */
class Cleanser implements CleansesStrings
{
    /**
     * Clean the raw string; for example, decode any stray HTML.
     *
     * @param string $raw
     * @return string
     */
    public function run(string $raw): string
    {
        return html_entity_decode($raw);
    }
}