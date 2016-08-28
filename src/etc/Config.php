<?php
namespace alphayax\freebox\os\etc;

/**
 * Class Config
 * @package alphayax\freebox\os\etc
 */
class Config {

    const CONFIG_DIRECTORY = __DIR__;

    /**
     * @param $confName
     * @return array
     */
    public static function get( $confName) {
        $configFile = static::CONFIG_DIRECTORY . DIRECTORY_SEPARATOR . $confName . '.json';
        if( file_exists( $configFile)){
            $confContent = file_get_contents( $configFile);
            return json_decode( $confContent, true);
        }
        return [];
    }

    /**
     * @param $confName
     * @param $confContent
     * @return bool
     */
    public static function set( $confName, $confContent) {
        $configFile = static::CONFIG_DIRECTORY . DIRECTORY_SEPARATOR . $confName . '.json';
        $confContent = json_encode( $confContent);
        return file_put_contents( $configFile, $confContent) != false;
    }

}
