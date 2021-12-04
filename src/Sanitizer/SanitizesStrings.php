<?php


namespace Lukaswhite\MetaTagsParser\Sanitizer;


interface SanitizesStrings
{
    /**
     * Sanitize the provided raw string.
     *
     * @param string $raw
     * @return string
     */
    public function run(string $raw): string;
}