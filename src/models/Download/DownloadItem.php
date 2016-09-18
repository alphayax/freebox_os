<?php
namespace alphayax\freebox\os\models\Download;
use alphayax\freebox\api\v3\models\Download\Task;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Omdb\Omdb;
use alphayax\freebox\os\utils\Unit;


class DownloadItem implements \JsonSerializable {

    /** @var \alphayax\freebox\api\v3\models\Download\Task */
    protected $downloadTask;

    protected $image;
    protected $name;
    protected $sizeHr;
    protected $rxTotalHr;
    protected $txTotalHr;
    protected $etaHr;
    protected $cleanName;
    protected $rxPct;
    protected $txPct;
    protected $path;


    public function __construct( Task $downloadTask) {
        $this->downloadTask = $downloadTask;
    }

    public function init() {
        $this->cleanName    = $this->getCleanName();
        $this->image        = $this->getImage();
        $this->sizeHr       = Unit::octetsToHumanReadable( $this->downloadTask->getSize());
        $this->rxTotalHr    = Unit::octetsToHumanReadable( $this->downloadTask->getRxBytes());
        $this->txTotalHr    = Unit::octetsToHumanReadable( $this->downloadTask->getTxBytes());
        $this->etaHr        = Unit::secondsToHumanReadable( $this->downloadTask->getEta());
        $this->rxPct        = $this->downloadTask->getRxPct() / 100;
        $this->txPct        = $this->downloadTask->getTxPct() / 100;
        $this->path         = base64_decode( $this->downloadTask->getDownloadDir());
    }

    public function getCleanName() {

        $name = $this->downloadTask->getName();

        $title = new MovieTitle($name);
        return $title->getCleanName();
    }

    /**
     * @todo : Meilleur systeme de cache
     * @return string
     */
    public function getImage() {

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
