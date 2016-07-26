<?php
namespace alphayax\freebox\os\utils;

/**
 * Class Unit
 * Units conversion utility
 * @package alphayax\freebox\os\utils
 */
class Unit {

    /**
     * Convert an amount of second into an Human Readable string
     * @param int $seconds
     * @return string
     */
    public static function secondsToHumanReadable( $seconds) {

        /// Trivial case
        if( empty( $seconds)){
            return '';
        }

        /// Seconds
        if( $seconds < 60){
            return sprintf('%us', $seconds);
        }

        /// Minutes
        $minutes = $seconds / 60;
        $seconds = $seconds % 60;
        if( $minutes < 60){
            return sprintf('%umn %us', $minutes, $seconds);
        }

        /// hours
        $hours   = $minutes / 60;
        $minutes = $minutes % 60;
        if( $hours < 24){
            return sprintf('%uh %umn %us', $hours, $minutes, $seconds);
        }

        /// Days
        $days  = $hours / 24;
        $hours = $hours % 24;

        return sprintf('%ud %uh %umn %us', $days, $hours, $minutes, $seconds);
    }

    /**
     * Convert amount of octets into a Human Readable string
     * @param int $size
     * @return string
     */
    public static function octetsToHumanReadable( $size){
        $units  = ['o', 'Ko', 'Mo', 'Go', 'To', 'Po'];
        $size   = max($size, 0);
        $pow    = floor(($size ? log($size) : 0) / log(1024));
        $pow    = min($pow, count($units) - 1);
        $size  /= (1 << (10 * $pow));

        return round($size, 3) . ' ' . $units[$pow];
    }

}
