<?php
namespace alphayax\freebox\os\models\Download;
use alphayax\freebox\api\v3\models\Download\Task;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Poster;
use alphayax\freebox\os\utils\Unit;


class DownloadItem implements \JsonSerializable {

    // Q&D fix
    const IMG_HOST = 'http://api.freehub.ondina.alphayax.com:14789/img/';

    /** @var \alphayax\freebox\api\v3\models\Download\Task */
    protected $downloadTask;

    protected $image;
    protected $name;
    protected $etaHr;
    protected $cleanName;
    protected $rxPct;
    protected $txPct;
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
    }

    /**
     * Initialize misc data from downloadTask
     */
    public function init() {
        $this->cleanName    = $this->movieTitle->getCleanName();
        $this->image        = $this->getImage();
        $this->etaHr        = Unit::secondsToHumanReadable( $this->downloadTask->getEta());
        $this->rxPct        = $this->downloadTask->getRxPct() / 100;
        $this->txPct        = $this->downloadTask->getTxPct() / 100;
        $this->path         = base64_decode( $this->downloadTask->getDownloadDir());
    }

    /**
     * @todo : Meilleur systeme de cache
     * @return string
     */
    public function getImage() {

        $title = $this->movieTitle->getCleanName();

        if( file_exists(  __DIR__ . '/../../../www/img/' . $title)){
            return static::IMG_HOST . $title;
        }

        $poster = Poster::getFromTitle( $title);
        if( empty( $poster) || $poster == 'N/A'){
            return '';
        }

        /// Download poster
        $img = file_get_contents( $poster);
        if( empty( $img)){
            trigger_error( "Poster cannot be downloaded : $poster");
            return '';
        }

        file_put_contents( __DIR__ . '/../../../www/img/' . $title, $img);    // TODO : Mettre un meilleur nom pour l'image
        return static::IMG_HOST . $title;
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
