<?php
namespace alphayax\freebox\os\etc;

/**
 * Class Config
 * @package alphayax\freebox\os\etc
 */
class Config {

    const CONFIG_DIRECTORY = __DIR__;

    /** @var array */
    protected static $configsCache = [];

    /**
     * @param $confName
     * @return array
     */
    public static function get( $confName) {

        if( ! array_key_exists( $confName, static::$configsCache)){
            static::load( $confName);
        }

        return static::$configsCache[$confName];
    }

    /**
     * @param $confName
     */
    protected static function load( $confName) {
        $configFile = static::getConfigFileFromConfigName( $confName);

        if( ! file_exists( $configFile)){
            static::$configsCache[$confName] = [];
            return;
        }

        $confContent = file_get_contents( $configFile);
        static::$configsCache[$confName] = json_decode( $confContent, true);
    }

    /**
     * @param $confName
     * @param $confContent
     * @return bool
     */
    public static function set( $confName, $confContent) {

        static::$configsCache[$confName] = $confContent;

        return static::write( $confName);
    }

    /**
     * @param $confName
     * @return bool
     */
    protected static function write( $confName) {
        $configFile = static::getConfigFileFromConfigName( $confName);

        $configContent = json_encode( static::$configsCache[$confName], JSON_PRETTY_PRINT);
        return false !== file_put_contents( $configFile, $configContent);
    }

    /**
     * @param $confName
     * @return string
     */
    protected static function getConfigFileFromConfigName( $confName) {
        return static::CONFIG_DIRECTORY . DIRECTORY_SEPARATOR . $confName . '.json';
    }

}
