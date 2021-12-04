# PHP Meta Tags Parser

Extracts metadata (title, description, Open Graph etc) from the content of a web page.

Note that this library simply deals with raw HTML, rather than try to tie you down to one particular method for retrieving the content of an external URL. (I usually use Guzzle, but to make it a dependency might cause difficulties in terms of versioning.)

## Installation

```bash
composer require lukaswhite/php-meta-tags-parser
```  

## Usage

```php
use Lukaswhite\MetaTagsParser\Parser;

$html = '<html><head>...</head></html>';

$parser = new Parser();
$result = $parser->parse($html);
```

### Using the result

The `parse()` method returns an object that encapsulates any page data it's extracted from the provided HTML.

```php
$result->getTitle();
$result->getDescription();
$result->getKeywords();
$result->getUrl();
$result->getFacebookAppId();

$result->openGraph()->getSiteName();
$result->openGraph()->getType();
$result->openGraph()->getTitle();
$result->openGraph()->getDescription();
$result->openGraph()->getLocale();
$result->openGraph()->getImages(); // returns an array of URLs
$result->openGraph()->getLatitude();
$result->openGraph()->getLongitude();

$result->toArray(); // all of the extracted metadata
```

It will also extract RSS and/or Atom feeds; `getFeeds()` returns an array of instances of the `Feed` class:

```php
$feed->getType(); // Feed::RSS or Feed::ATOM
$feed->getUri();
$feed->getTitle();
```

## Cleansing the data

The package ships with a very simple string cleanser; essentially it just decodes any HTML entities. You're free to provide your own cleanser; just implement the `CleansesStrings` interface, and provide an instance to the parser's constructor. It simply needs to provide a `run()` method, that accepts a string and returns the cleansed version.

## Sanitizing the data

The package ships with a very simple string sanitzer; under the hood it simply uses the `strip_tags()` function. If you wish to provide your own sanitizer, just implement the `SanitizesStrings` interface, and provide an instance to the parser's constructor. It simply needs to provide a `run()` method, that accepts a string and returns the sanitized version.