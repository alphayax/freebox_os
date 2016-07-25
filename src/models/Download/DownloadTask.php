<?php
namespace alphayax\freebox\os\models\Download;
use alphayax\freebox\api\v3\models\Download\Task;
use alphayax\freebox\os\utils\Omdb\Omdb;


class DownloadTask {

    /** @var \alphayax\freebox\api\v3\models\Download\Task */
    protected $downloadTask = [];

    public function __construct( Task $downloadTask) {
        $this->downloadTask = $downloadTask;
    }

    public function getSerieTitle() {

        $name = $this->downloadTask->getName();
        $name = str_replace( ['.', '_'], ' ', $name);

        $name = preg_replace(['/(\[[a-zA-Z0-9_ -]+\])/', '/(\([a-zA-Z0-9_ -]+\))/'], '', $name);

        $pattern = '/(.*) (S[0-9]+E[0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            return trim( $rez[1]);
        }

        $pattern = '/(.*) (S[0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            return trim( $rez[1]);
        }

        return $name;
    }

    public function getImage() {

        $title = $this->getSerieTitle();

        if( in_array( $title, ['', '.', '..'])){
            return 'folder.png'; // TODO: verifier que c'est un dossier
        }

        if( file_exists(  __DIR__ . '/../../www/img/' . $title)){
            return 'img/'. $title;
        }

        $movie = Omdb::search( $title);
        $poster = $movie->getPoster();


        if( empty( $poster) || $poster == 'N/A'){
            return 'folder.png';
        }

        $img = file_get_contents( $poster);

        file_put_contents( __DIR__ . '/../../www/img/' . $title, $img);    // TODO : Mettre un meilleur nom pour l'image
        return 'img/'. $title;
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
        return static::convertIntoHumanReadableSize( $this->downloadTask->getSize());
    }

    public function getDlHr() {
        return static::convertIntoHumanReadableSize( $this->downloadTask->getRxBytes());
    }

    public function getUlHr() {
        return static::convertIntoHumanReadableSize( $this->downloadTask->getTxBytes());
    }

    /**
     * @todo : Passer cette methode dans une classe utilitaire
     * @param        $size int Size in octects
     * @return string
     */
    protected static function convertIntoHumanReadableSize( $size){

        $units = array('o', 'Ko', 'Mo', 'Go', 'To');

        $size = max($size, 0);
        $pow = floor(($size ? log($size) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $size /= (1 << (10 * $pow));

        return round($size, 3) . ' ' . $units[$pow];
    }
}
