<?php
namespace alphayax\freebox\os\utils;

class MovieTitle implements \JsonSerializable {

    protected $rawTitle;
    protected $episode;
    protected $season;
    protected $cleanName;
    protected $year;

    public function __construct( $rawTitle) {
        $this->rawTitle = $rawTitle;
        $this->extractData();
    }

    protected function extractData() {

        $name = $this->rawTitle;

        // Remove extension
        $name = preg_replace('/(\.[a-z0-9]{1,4})$/', '', $name);

        // Replace special spaces with true spaces
        $name = str_replace( ['.', '_'], ' ', $name);

        // Remove tags
        $name = preg_replace(['/(\[[a-zA-Z0-9_ -]+\])/', '/(\([a-zA-Z0-9_ -]+\))/'], '', $name);

        // Extract year
        $pattern = '/.*[^0-9]([0-9]{4})[^0-9].*/';
        if( preg_match( $pattern, $name, $rez)){
            $this->year = trim( $rez[1]);
            $name = preg_replace('/([0-9]{4})/', '', $name);
        }

        // Try to find Season and Episode info
        $pattern = '/(.*)[ -][Ss]([0-9]+)-?[Ee]([0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            $this->season    = intval( $rez[2]);
            $this->episode   = intval( $rez[3]);
            return;
        }

        // Try to find Season and Episode info
        $pattern = '/(.*)[ -]([0-9]+)[Xx]([0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            $this->season    = intval( $rez[2]);
            $this->episode   = intval( $rez[3]);
            return;
        }

        // Try to find Season info
        $pattern = '/(.*)[ -]{Ss]([0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            $this->season    = intval( $rez[2]);
            return;
        }

        $pattern = '/(.*)[ -]Saison ?([0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            $this->season    = intval( $rez[2]);
            return;
        }

        // Try to find Episode number
        $pattern = '/(.*) ([0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            $this->episode   = intval( $rez[2]);
            return;
        }

        /*
        // Try to clean number prefixes
        // Not working for "12 Monkeys"
        $pattern = '/^[0-9]+(.*)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            return;
        }
        */
        $this->cleanName = trim( $name);
    }

    /**
     * @return int
     */
    public function getEpisode() {
        return $this->episode;
    }

    /**
     * @return int
     */
    public function getSeason() {
        return $this->season;
    }

    /**
     * @return string
     */
    public function getCleanName() {
        return $this->cleanName;
    }

    /**
     * @return int
     */
    public function getYear() {
        return $this->year;
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
