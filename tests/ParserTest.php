<?php


class ParserTest extends \PHPUnit\Framework\TestCase
{
    public function testGettingStandardMetadata( )
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'standard.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);
        $arr = $result->toArray( );

        $this->assertEquals(
            'Test Title',
            $result->getTitle()
        );

        $this->assertArrayHasKey( 'title', $arr );
        $this->assertEquals(
            'Test Title',
            $arr[ 'title' ]
        );

        $this->assertEquals(
            'Just testing standard meta tags',
            $result->getDescription( )
        );

        $this->assertArrayHasKey( 'description', $arr );
        $this->assertEquals(
            'Just testing standard meta tags',
            $arr[ 'description' ]
        );

        $this->assertEquals(
            'http://example.com',
            $result->getUrl()
        );

        $this->assertArrayHasKey( 'url', $arr );
        $this->assertEquals(
            'http://example.com',
            $arr[ 'url' ]
        );

        $this->assertTrue(
            is_array( $result->getKeywords( ) )
        );

        $this->assertTrue(
            in_array( 'PHP', $result->getKeywords( ) )
        );

        $this->assertTrue(
            in_array( 'meta tags',$result->getKeywords( ) )
        );

        $this->assertTrue(
            in_array( 'Open Graph', $result->getKeywords( ) )
        );

        $this->assertArrayHasKey( 'keywords', $arr );
        $this->assertEquals(
            $result->getKeywords( ),
            $arr[ 'keywords' ]
        );

    }

    public function testGettingOpenGraphData( )
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'open-graph.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser( );

        $result = $parser->parse( $html );
        $arr = $result->toArray( );

        $this->assertArrayHasKey( 'og', $arr );

        $this->assertTrue( is_array( $arr[ 'og' ] ) );

        $ogArr = $arr[ 'og' ];

        $this->assertEquals(
            'Open Graph Test Site',
            $result->openGraph( )->getSiteName( )
        );

        $this->assertArrayHasKey( 'site_name', $ogArr );

        $this->assertEquals(
            'Open Graph Test Site',
            $ogArr[ 'site_name' ]
        );

        $this->assertEquals(
            'Open Graph Test',
            $result->openGraph( )->getTitle( )
        );

        $this->assertEquals(
            'Just testing parsing Open Graph tags',
            $result->openGraph( )->getDescription( )
        );

        $this->assertTrue(
            is_array( $result->openGraph( )->getImages( ) )
        );

        $this->assertEquals( 1, count( $result->openGraph( )->getImages( ) ) );

        $this->assertEquals(
            'https://example.com/image.png',
            $result->openGraph( )->getImages( )[ 0 ]
        );

        $this->assertEquals(
            'website',
            $result->openGraph( )->getType( )
        );

        $this->assertEquals(
            'https://example.com',
            $result->openGraph( )->getUrl( )
        );

        $this->assertEquals(
            'en_US',
            $result->openGraph( )->getLocale( )
        );

        $this->assertEquals(
            37.416343,
            $result->openGraph( )->getLatitude( )
        );

        $this->assertEquals(
            -122.153013,
            $result->openGraph( )->getLongitude( )
        );

        $this->assertEquals(
            42,
            $result->openGraph( )->getAltitude( )
        );

        $arr = $result->toArray( );

        $this->assertArrayHasKey( 'title', $arr );


    }

    public function testGettingMinimalOpenGraphData( )
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'open-graph-minimal.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);
        $arr = $result->toArray();

        $this->assertArrayHasKey('og', $arr);

        $this->assertTrue(is_array($arr['og']));

        $ogArr = $arr['og'];

        $this->assertEquals(
            'Open Graph Test',
            $result->openGraph()->getTitle()
        );

    }

    public function testGettingFacebookMeta( )
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'facebook.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);

        $this->assertEquals(
            '12345678910',
            $result->getFacebookAppId()
        );
    }

    public function test_escapes_stray_html_in_page_descriptions()
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'html-in-page-description.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);

        $this->assertEquals(
            'Ticketless fans looked "like a line of 6,000 zombies trying to get in" and one even "hijacked a disabled child\'s wheelchair".',
            $result->getDescription()
        );
    }

    public function test_removes_any_erroneous_tags()
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'stray-tags.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);

        $this->assertEquals(
            'I have a script.',
            $result->getDescription()
        );
    }

    public function test_extracts_feeds()
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'feeds.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);

        $this->assertTrue(is_array($result->getFeeds()));
        $this->assertEquals(2, count($result->getFeeds()));

        $this->assertEquals(1, count($result->getFeeds(\Lukaswhite\MetaTagsParser\Feed::RSS)));
        $this->assertEquals(1, count($result->getFeeds(\Lukaswhite\MetaTagsParser\Feed::ATOM)));

        $this->assertArrayHasKey('feeds', $result->toArray());
        $this->assertTrue(is_array($result->toArray()['feeds']));
        $this->assertEquals(2, count($result->toArray()['feeds']));

    }

    public function test_extracts_rss_feeds()
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'rss.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);

        $this->assertTrue(is_array($result->getFeeds()));
        $this->assertEquals(1, count($result->getFeeds()));
        $this->assertEquals(1, count($result->getFeeds(\Lukaswhite\MetaTagsParser\Feed::RSS)));
        $this->assertEquals(0, count($result->getFeeds(\Lukaswhite\MetaTagsParser\Feed::ATOM)));
        $this->assertInstanceOf(\Lukaswhite\MetaTagsParser\Feed::class, $result->getFeeds()[0]);
        /** @var \Lukaswhite\MetaTagsParser\Feed $feed */
        $feed = $result->getFeeds()[0];
        $this->assertEquals(\Lukaswhite\MetaTagsParser\Feed::RSS, $feed->getType());
        $this->assertEquals('http://example.com/feed.rss', $feed->getUri());
        $this->assertEquals('RSS Feed', $feed->getTitle());

        $this->assertArrayHasKey('feeds', $result->toArray());
        $this->assertTrue(is_array($result->toArray()['feeds']));
        $this->assertEquals(1, count($result->toArray()['feeds']));
        $this->assertTrue(is_array($result->toArray()['feeds'][0]));
        $this->assertArrayHasKey('type', $result->toArray()['feeds'][0]);
        $this->assertEquals(\Lukaswhite\MetaTagsParser\Feed::RSS, $result->toArray()['feeds'][0]['type']);
        $this->assertArrayHasKey('uri', $result->toArray()['feeds'][0]);
        $this->assertEquals('http://example.com/feed.rss', $result->toArray()['feeds'][0]['uri']);
        $this->assertArrayHasKey('title', $result->toArray()['feeds'][0]);
        $this->assertEquals('RSS Feed', $result->toArray()['feeds'][0]['title']);
    }

    public function test_extracts_atom_feeds()
    {
        $html = file_get_contents(
            sprintf(
                '%s%s%s%s%s',
                __DIR__,
                DIRECTORY_SEPARATOR,
                'fixtures',
                DIRECTORY_SEPARATOR,
                'atom.html'
            )
        );

        $parser = new \Lukaswhite\MetaTagsParser\Parser();

        $result = $parser->parse($html);

        $this->assertTrue(is_array($result->getFeeds()));
        $this->assertEquals(1, count($result->getFeeds()));
        $this->assertEquals(1, count($result->getFeeds(\Lukaswhite\MetaTagsParser\Feed::ATOM)));
        $this->assertEquals(0, count($result->getFeeds(\Lukaswhite\MetaTagsParser\Feed::RSS)));
        $this->assertInstanceOf(\Lukaswhite\MetaTagsParser\Feed::class, $result->getFeeds()[0]);
        /** @var \Lukaswhite\MetaTagsParser\Feed $feed */
        $feed = $result->getFeeds()[0];
        $this->assertEquals(\Lukaswhite\MetaTagsParser\Feed::ATOM, $feed->getType());
        $this->assertEquals('http://example.com/feed.xml', $feed->getUri());
        $this->assertEquals('Atom Feed', $feed->getTitle());
    }
}