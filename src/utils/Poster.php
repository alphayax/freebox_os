<?php
namespace alphayax\freebox\os\utils;

use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\utils\Omdb\Omdb;

/**
 * Class Poster
 * @package alphayax\freebox\os\utils
 */
class Poster {

    // Q&D fix
    const IMG_HOST   = 'http://api.freehub.ondina.alphayax.com:14789/img/';
    const POSTER_ADI = __DIR__ . '/../../www/img/';

    /**
     * @param string $title
     * @return string
     */
    public static function getFromTitle( $title) {

        if( file_exists( static::POSTER_ADI . $title)){
            return static::IMG_HOST . $title;
        }

        $poster = static::getFromCache( $title);
        if( empty( $poster)){
            $poster = static::getFromOmdb( $title);
        }

        static::downloadFromOmdb( $poster['Poster'], $title);

        return static::IMG_HOST . $title;
    }

    /**
     * Load poster from local cache
     * @param $title
     * @return array
     */
    protected static function getFromCache( $title) {
        $conf = Config::get( 'poster');

        /// Trivial case : result is cached
        if( array_key_exists( $title, $conf)){
            return $conf[$title];
        }
        return [];
    }

    /**
     * @param $title
     * @return array
     */
    protected static function getFromOmdb( $title) {
        $movie = Omdb::search( $title);

        $conf = Config::get( 'poster');
        $conf[$title] = $movie->toArray();
        Config::set( 'poster', $conf);

        return $conf[$title];
    }

    /**
     * @param string $posterUrl
     * @param        $title
     * @return bool
     */
    protected static function downloadFromOmdb( $posterUrl, $title) {

        if( empty( $posterUrl) || $posterUrl == 'N/A'){
            return false;
        }

        /// Download poster
        $img = file_get_contents( $posterUrl);
        if( empty( $img)){
            trigger_error( 'Poster cannot be downloaded : '. $posterUrl);
            return false;
        }

        $poster_afi = static::POSTER_ADI . $title;
        $fileSaved = file_put_contents( $poster_afi, $img);    // TODO : Mettre un meilleur nom pour l'image
        if( false === $fileSaved){
            trigger_error( 'Poster cannot be saved : '. $poster_afi);
            return false;
        }

        return true;
    }

}
