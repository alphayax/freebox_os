<?php
namespace alphayax\freebox\os\models\FileSystem;
use alphayax\freebox\api\v3\symbols\FileSystem\FileInfoType;
use alphayax\freebox\os\utils\MovieTitle;

/**
 * Class FileInfo
 * @package alphayax\freebox\os\models\FileSystem
 */
class FileInfo implements \JsonSerializable {

    // Q&D fix
    const IMG_HOST = 'http://api.freehub.ondina.alphayax.com:14789/img/';

    /** @var \alphayax\freebox\api\v3\models\FileSystem\FileInfo  */
    protected $fileInfo;

    /** @var \alphayax\freebox\os\utils\MovieTitle */
    protected $movieTitle;

    /** @var string */
    protected $image = '';

    protected $isDir;
    protected $path;
    protected $name;


    /**
     * FileInfo constructor.
     * @param \alphayax\freebox\api\v3\models\FileSystem\FileInfo $fileInfo
     */
    public function __construct( \alphayax\freebox\api\v3\models\FileSystem\FileInfo $fileInfo) {
        $this->fileInfo = $fileInfo;
        $this->name     = $this->fileInfo->getName();
        $this->path     = $this->fileInfo->getPath();
        $this->isDir    = $this->isDir();

        // Directory
        if( $this->isDir()){
            $this->image = static::IMG_HOST . 'folder.png';
        }

        // Videos
        if( $this->isVideo()){
            $this->movieTitle = new MovieTitle( $this->fileInfo->getName());
            $this->name  = $this->movieTitle->getCleanName();
        }
    }

    protected function isDir() {
        return $this->fileInfo->getType() == FileInfoType::DIRECTORY;
    }

    protected function isVideo() {
        $mimeType = $this->fileInfo->getMimetype();
        $type = explode( '/', $mimeType);
        return $type[0] == 'video';
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
