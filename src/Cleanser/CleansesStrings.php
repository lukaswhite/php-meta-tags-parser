<?php


namespace Lukaswhite\MetaTagsParser\Cleanser;


interface CleansesStrings
{
    /**
     * Clean the raw string; for example, decode any stray HTML.
     *
     * @param string $raw
     * @return string
     */
    public function run(string $raw): string;
}