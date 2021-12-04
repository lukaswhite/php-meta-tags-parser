<?php


namespace Lukaswhite\MetaTagsParser\Sanitizer;


class Sanitizer implements SanitizesStrings
{
    /**
     * Sanitize the provided raw string.
     *
     * @param string $raw
     * @return string
     */
    public function run(string $raw): string
    {
        return strip_tags($raw);
    }
}