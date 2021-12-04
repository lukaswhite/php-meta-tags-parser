# PHP Meta Tags Parser

Extracts metadata (title, description, Open Graph etc) from the content of a web page.

Note that this library simply deals with raw HTML, rather than try to tie you down to one particular method for retrieving the content of an external URL.

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

## Cleansing the data

The package ships with a very simple string cleanser; essentially it just decodes any HTML entities. You're free to provide your own cleanser; just implement the `CleansesStrings` interface, and provide an instance to the parser's constructor.

## Sanitzing the data

The package ships with a very simple string sanitzer; under the hood it simply uses the `strip_tags()` function. If you wish to provide your own sanitizer, just implement the `SanitizesStrings` interface, and provide an instance to the parser's constructor.