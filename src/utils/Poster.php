<?php
namespace alphayax\freebox\os\utils;

use alphayax\freebox\os\utils\Omdb\Omdb;

class Poster {

    protected static $conf = [];

    public static function getFromTitle( $title) {

        if( empty( static::$conf)){
            static::loadConfig();
        }

        /// Trivial case : result is cached
        if( array_key_exists( $title, static::$conf)){
            return static::$conf[$title]['Poster'];
        }

        $movie = Omdb::search( $title);

        static::$conf[$title] = $movie->toArray();
        static::saveConfig();

        return static::$conf[$title]['Poster'];
    }

    protected static function loadConfig() {
        $posterConfFile = __DIR__ . '/../etc/poster.json';
        if( ! is_file( $posterConfFile)) {
            return;
        }
        $confJson = file_get_contents( $posterConfFile);
        static::$conf = json_decode( $confJson, true);
    }

    protected static function saveConfig() {
        $posterConfFile = __DIR__ . '/../etc/poster.json';
        file_put_contents( $posterConfFile, json_encode( static::$conf, JSON_PRETTY_PRINT));
    }
}
