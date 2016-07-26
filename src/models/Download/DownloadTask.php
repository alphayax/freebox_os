<?php
namespace alphayax\freebox\os\models\Download;
use alphayax\freebox\api\v3\models\Download\Task;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Omdb\Omdb;
use alphayax\freebox\os\utils\Unit;


class DownloadTask {

    /** @var \alphayax\freebox\api\v3\models\Download\Task */
    protected $downloadTask = [];

    public function __construct( Task $downloadTask) {
        $this->downloadTask = $downloadTask;
    }

    public function getSerieTitle() {

        $name = $this->downloadTask->getName();

        $title = new MovieTitle($name);
        return $title->getCleanName();
    }

    public function getImage() {

        $title = $this->getSerieTitle();

        if( file_exists(  __DIR__ . '/../../www/img/' . $title)){
            return 'img/'. $title;
        }

        $movie = Omdb::search( $title);

        if( $movie->getResponse() == 'False'){
        }
        $poster = $movie->getPoster();



        if( empty( $poster) || $poster == 'N/A'){
            return '';
        }

        $img = file_get_contents( $poster);
        if( empty( $img)){
            return '';
        }

        file_put_contents( __DIR__ . '/../../www/img/' . $title, $img);    // TODO : Mettre un meilleur nom pour l'image
        return 'img/'. $title;
    }

    public function getEtaHr() {
        $eta = $this->downloadTask->getEta();
        return Unit::secondsToHumanReadable( $eta);
    }

    function __get($name) {
        if( method_exists( $this->downloadTask, $name)){
            return $this->downloadTask->$name();
        }
        if( property_exists( Task::class, $name)){
            return $this->downloadTask->$name;
        }
        return '';
    }

    function __isset($name) {
        return( method_exists( $this->downloadTask, $name) || property_exists( Task::class, $name));
    }


    function __call($name, $arguments) {
        if( method_exists( $this->downloadTask, $name)){
            $this->downloadTask->$name( $arguments);
        }
    }

    public function getCleanName() {
        $name = $this->downloadTask->getName();
        $name = str_replace( ['.', '_'], ' ', $name);

        $pattern = '/(.*) (S[0-9]+E[0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            return $rez[1] . ' - '. $rez[2];
        }

        return $name;
    }

    public function getSizeHr(){
        return Unit::octetsToHumanReadable( $this->downloadTask->getSize());
    }

    public function getDlHr() {
        return Unit::octetsToHumanReadable( $this->downloadTask->getRxBytes());
    }

    public function getUlHr() {
        return Unit::octetsToHumanReadable( $this->downloadTask->getTxBytes());
    }

}
