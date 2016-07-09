<?php
namespace alphayax\freebox\os\models;
use alphayax\freebox\api\v3\models\Download\Task;


class DownloadTask {

    /** @var \alphayax\freebox\api\v3\models\Download\Task */
    protected $downloadTask = [];

    public function __construct( Task $downloadTask) {
        $this->downloadTask = $downloadTask;
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
