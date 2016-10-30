<?php
namespace alphayax\freebox\os\utils;

use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\utils\Omdb\Omdb;

/**
 * Class Poster
 * @package alphayax\freebox\os\utils
 */
class Poster {

    /**
     * @param string $title
     * @return string
     */
    public static function getFromTitle( $title) {

        $conf = Config::get( 'poster');

        /// Trivial case : result is cached
        if( array_key_exists( $title, $conf)){
            return $conf[$title]['Poster'];
        }

        $movie = Omdb::search( $title);

        $conf[$title] = $movie->toArray();
        Config::set( 'poster', $conf);

        return $conf[$title]['Poster'];
    }

}
