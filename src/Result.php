<?php

namespace Lukaswhite\MetaTagsParser;

/**
 * Class Result
 *
 * @package Lukaswhite\MetaTagsParser
 */
class Result
{
    use HasTitleAndDescription;

    /**
     * The Open Graph data
     *
     * @var OpenGraph
     */
    protected $openGraph;

    /**
     * The keywords
     *
     * @var array
     */
    protected $keywords = [ ];

    /**
     * The Facebook app ID
     *
     * @var string
     */
    protected $facebookAppId;

    /**
     * Result constructor.
     */
    public function __construct( )
    {
        $this->openGraph = new OpenGraph( );
    }

    /**
     * Get the Open Graph data
     *
     * @return OpenGraph
     */
    public function openGraph( ) : OpenGraph
    {
        return $this->openGraph;
    }

    /**
     * Get the keywords
     *
     * @return array
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set the keywords
     *
     * @param $keywords
     * @return $this
     */
    public function setKeywords( $keywords )
    {
        if ( is_string( $keywords ) ) {
            $keywords = array_map(
                function( $keyword ) {
                    return trim( $keyword );
                },
                explode( ',', $keywords )
            );
        }

        $this->keywords = $keywords;
        return $this;
    }

    /**
     * @return string
     */
    public function getFacebookAppId()
    {
        return $this->facebookAppId;
    }

    /**
     * @param string $facebookAppId
     * @return Result
     */
    public function setFacebookAppId($facebookAppId)
    {
        $this->facebookAppId = $facebookAppId;
        return $this;
    }

    /**
     * Convert the result into an array
     *
     * @return array
     */
    public function toArray( )
    {
        return [
            'title'             =>  $this->getTitle( ),
            'description'       =>  $this->getDescription( ),
            'keywords'          =>  $this->getKeywords( ),
            'og'                =>  $this->openGraph( )->toArray( ),
        ];
    }

}