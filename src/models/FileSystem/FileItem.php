<?php
namespace alphayax\freebox\os\models\FileSystem;
use alphayax\freebox\api\v3\models\Download\Task;
use alphayax\freebox\api\v3\symbols\FileSystem\FileInfoType;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Omdb\Omdb;
use alphayax\freebox\os\utils\Unit;


class FileItem implements \JsonSerializable {

    /** @var \alphayax\freebox\api\v3\models\FileSystem\FileInfo  */
    protected $fileInfo;

    protected $path;
    protected $name;
    protected $image;


    /**
     * FileItem constructor.
     * @param \alphayax\freebox\api\v3\models\FileSystem\FileInfo $fileInfo
     */
    public function __construct(\alphayax\freebox\api\v3\models\FileSystem\FileInfo $fileInfo) {
        $this->fileInfo = $fileInfo;
    }

    public function init() {
        $this->image    = $this->getImage();
        $this->name     = $this->getCleanName();
        $this->path     = $this->fileInfo->getPath();
    }

    public function getCleanName() {

        $name = $this->fileInfo->getName();

        $title = new MovieTitle($name);
        return $title->getCleanName();
    }

    public function isDir() {
        return $this->fileInfo->getType() == FileInfoType::DIRECTORY;
    }

    /**
     * @todo : Meilleur systeme de cache
     * @return string
     */
    public function getImage() {

        if( $this->isDir()){
            return 'folder.png';
        }
        $title = $this->getCleanName();

        if( file_exists(  __DIR__ . '/../../www/img/' . $title)){
            return 'img/'. $title;
        }

        $movie = Omdb::search( $title);

        if( $movie->getResponse() == 'False'){
            return '';
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

    /**
     * Return an array representation of the model properties
     * @return array
     */
    public function toArray(){
        $ModelArray = [];
        foreach( get_object_vars( $this) as $propertyName => $propertyValue){
            if( is_object( $propertyValue)){
                /// TODO : Faire un meilleur check
                $ModelArray[$propertyName] = $propertyValue->toArray();
            } else {
                $ModelArray[$propertyName] = $propertyValue;
            }
        }
        return $ModelArray;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize() {
        return $this->toArray();
    }

}
