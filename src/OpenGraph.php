<?php

namespace Lukaswhite\MetaTagsParser;

/**
 * Class OpenGraph
 *
 * Encapsulates the Open Graph metadata
 *
 * @package Lukaswhite\MetaTagsParser
 */
class OpenGraph
{
    use HasTitleAndDescription;

    /**
     * The images
     *
     * @var array
     */
    protected $images = [ ];

    /**
     * The type
     *
     * @var string
     */
    protected $type;

    /**
     * The URL
     *
     * @var string
     */
    protected $url;

    /**
     * Thelocale
     *
     * @var string
     */
    protected $locale;

    /**
     * The site name
     *
     * @var string
     */
    protected $siteName;

    /**
     * The latitude
     *
     * @var float
     */
    protected $latitude;

    /**
     * The longitude
     *
     * @var float
     */
    protected $longitude;

    /**
     * The altitude
     *
     * @var int
     */
    protected $altitude;

    /**
     * @return array
     */
    public function getImages( ) : array
    {
        return $this->images;
    }

    /**
     * Add an image
     *
     * @param string $url
     * @return self
     */
    public function addImage( string $url ) : self
    {
        $this->images[ ] = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getType( ) : ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return self
     */
    public function setType( string $type ) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl( ) : ?string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return self
     */
    public function setUrl( $url ) : self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return string
     */
    public function getSiteName( ) : ?string
    {
        return $this->siteName;
    }

    /**
     * @param string $siteName
     * @return self
     */
    public function setSiteName( string $siteName ) : self
    {
        $this->siteName = $siteName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLocale( ) : ?string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return self
     */
    public function setLocale( string $locale ) : self
    {
        $this->locale = $locale;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return OpenGraph
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return OpenGraph
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return int
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param int $altitude
     * @return OpenGraph
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
        return $this;
    }

    /**
     * Convert the result into an array
     *
     * @return array
     */
    public function toArray( ) : array
    {
        return [
            'site_name'         =>  $this->getSiteName( ),
            'type'              =>  $this->getType( ),
            'title'             =>  $this->getTitle( ),
            'description'       =>  $this->getDescription( ),
            'locale'            =>  $this->getLocale( ),
            'images'            =>  $this->getImages( ),
            'latitude'          =>  $this->getLatitude( ),
            'longitude'         =>  $this->getLongitude( ),
            'altitude'          =>  $this->getAltitude( ),
        ];
    }
}