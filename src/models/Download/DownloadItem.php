<?php
namespace alphayax\freebox\os\models\Download;
use alphayax\freebox\api\v3\models\Download\Task;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Unit;


class DownloadItem implements \JsonSerializable {

    /** @var \alphayax\freebox\api\v3\models\Download\Task */
    protected $downloadTask;

    protected $image = '';
    protected $etaHr;
    protected $path;

    /** @var MovieTitle */
    protected $movieTitle;

    /**
     * DownloadItem constructor.
     * @param \alphayax\freebox\api\v3\models\Download\Task $downloadTask
     */
    public function __construct( Task $downloadTask) {
        $this->downloadTask = $downloadTask;
        $this->movieTitle   = new MovieTitle( $this->downloadTask->getName());
        $this->path         = base64_decode( $this->downloadTask->getDownloadDir());
        $this->etaHr        = Unit::secondsToHumanReadable( $this->downloadTask->getEta());
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
