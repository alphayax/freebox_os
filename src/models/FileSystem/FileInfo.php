<?php
namespace alphayax\freebox\os\models\FileSystem;

use alphayax\freebox\api\v3\symbols\FileSystem\FileInfoType;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Omdb\Omdb;
use alphayax\freebox\os\utils\Unit;

class FileInfo {

    /** @var \alphayax\freebox\api\v3\models\FileSystem\FileInfo  */
    protected $fileInfo;


    public function __construct( \alphayax\freebox\api\v3\models\FileSystem\FileInfo $fileInfo) {

        $this->fileInfo = $fileInfo;
    }


    public function getSerieTitle() {

        $name = $this->fileInfo->getName();
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

        return $return;
    }

    public function getSizeHr() {
        return Unit::octetsToHumanReadable( $this->fileInfo->getSize());
    }

    public function isDir() {
        return $this->fileInfo->getType() == FileInfoType::DIRECTORY;
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
            return 'folder.png'; // TODO: verifier que c'est un dossier
        }

        $movie = Omdb::search( $title);
        $poster = $movie->getPoster();

        if( empty( $poster) || $poster == 'N/A'){
            return '';
            return 'folder.png';
        }

        $img = file_get_contents( $poster);

        if( empty( $img)){
            return '';
            return 'folder.png';
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
