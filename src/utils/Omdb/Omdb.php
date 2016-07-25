<?php
namespace alphayax\freebox\os\utils\Omdb;
use alphayax\rest\Rest;


class Omdb {

    public static function search( $title) {

        $param = http_build_query([
            't' => $title,
            'r' => 'json',
        ]);

        $url = 'http://www.omdbapi.com/?'. $param;
        $rest = new Rest( $url);
        $rest->GET([
            't' => $title,
        ]);

        $rez = $rest->getCurlResponse();

        return new Movie( $rez);
    }

}
