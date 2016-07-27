<?php
namespace alphayax\freebox\os\models\FileSystem;

use alphayax\freebox\api\v3\symbols\FileSystem\FileInfoType;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Omdb\Omdb;
use alphayax\freebox\os\utils\Poster;
use alphayax\freebox\os\utils\Unit;

class FileInfo {

    /** @var \alphayax\freebox\api\v3\models\FileSystem\FileInfo  */
    protected $fileInfo;

    /** @var \alphayax\freebox\os\utils\MovieTitle */
    protected $movieTitle;

    /**
     * FileInfo constructor.
     * @param \alphayax\freebox\api\v3\models\FileSystem\FileInfo $fileInfo
     */
    public function __construct( \alphayax\freebox\api\v3\models\FileSystem\FileInfo $fileInfo) {
        $this->fileInfo = $fileInfo;

        // Videos
        if( $this->isVideo()){
            /// TODO
            $this->movieTitle = new MovieTitle( $this->fileInfo->getName());
        }
    }

    public function getSerieTitle() {
        $title = new MovieTitle( $this->fileInfo->getName());
        return $title->getCleanName();
    }

    public function getWrappedName() {
        return wordwrap( $this->fileInfo->getName(), 25, PHP_EOL, true);
    }

    public function getMovieInfo() {
        $title = new MovieTitle( $this->fileInfo->getName());
        $return = [];

        $season = $title->getSeason();
        if( $season){
            $return[] = "Saison $season";
        }

        $episode = $title->getEpisode();
        if( $episode){
            $return[] = "Episode $episode";
        }

        return implode( ' - ', $return);
    }

    public function getSizeHr() {
        return Unit::octetsToHumanReadable( $this->fileInfo->getSize());
    }

    public function isDir() {
        return $this->fileInfo->getType() == FileInfoType::DIRECTORY;
    }

    public function isVideo() {
        $mimeType = $this->fileInfo->getMimetype();
        $type = explode( '/', $mimeType);
        return $type[0] == 'video';
    }

    public function getTypeClass() {

        $isDir = $this->fileInfo->getType() == FileInfoType::DIRECTORY;
        return $isDir ? 'panel-primary' : 'panel-default';
    }

    public function getImage() {

        $title = $this->getSerieTitle();

        if( file_exists(  __DIR__ . '/../../www/img/' . $title)){
            return 'img/'. $title;
        }

        if( in_array( $title, ['', '.', '..'])){
            return '';
        }

        $poster = Poster::getFromTitle( $title);
        //$movie = Omdb::search( $title);
        //$poster = $movie->getPoster();

        if( empty( $poster) || $poster == 'N/A'){
            return '';
        }

        $img = file_get_contents( $poster);

        if( empty( $img)){
            return '';
        }
        // TODO : Attention. Le nom de fichier peut contenir les caracteres speciaux . .. / \

        file_put_contents( __DIR__ . '/../../www/img/' . $title, $img);    // TODO : Mettre un meilleur nom pour l'image
        return 'img/'. $title;
    }

    function __get($name) {
        if( method_exists( $this->fileInfo, $name)){
            return $this->fileInfo->$name();
        }
        if( property_exists( \alphayax\freebox\api\v3\models\FileSystem\FileInfo::class, $name)){
            return $this->fileInfo->$name;
        }
        return '';
    }

    function __isset($name) {
        return( method_exists( $this->fileInfo, $name) || property_exists( \alphayax\freebox\api\v3\models\FileSystem\FileInfo::class, $name));
    }


    function __call($name, $arguments) {
        if( method_exists( $this->fileInfo, $name)){
            $this->fileInfo->$name( $arguments);
        }
    }

    public function getCleanName() {
        $name = $this->fileInfo->getName();
        $name = str_replace( ['.', '_'], ' ', $name);

        $pattern = '/(.*) (S[0-9]+E[0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            return $rez[1] . ' - '. $rez[2];
        }

        return $name;
    }

}
