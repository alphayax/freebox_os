<?php
namespace alphayax\freebox\os\utils\Omdb;

class Movie implements \JsonSerializable {

    protected $Title;
    protected $Year;
    protected $Rated;
    protected $Released;
    protected $Runtime;
    protected $Genre;
    protected $Director;
    protected $Writer;
    protected $Actors;
    protected $Plot;
    protected $Language;
    protected $Country;
    protected $Awards;
    protected $Poster;
    protected $Metascore;
    protected $imdbRating;
    protected $imdbVotes;
    protected $imdbID;
    protected $Type;
    protected $Response;


    public function __construct( $data) {
        foreach( $data as $item => $val) {
            if( property_exists(self::class, $item)) {
                $this->$item = $val;
            }
        }
    }

    /**
     * @return mixed
     */
    public function getTitle() {
        return $this->Title;
    }

    /**
     * @return mixed
     */
    public function getYear() {
        return $this->Year;
    }

    /**
     * @return mixed
     */
    public function getRated() {
        return $this->Rated;
    }

    /**
     * @return mixed
     */
    public function getReleased() {
        return $this->Released;
    }

    /**
     * @return mixed
     */
    public function getRuntime() {
        return $this->Runtime;
    }

    /**
     * @return mixed
     */
    public function getGenre() {
        return $this->Genre;
    }

    /**
     * @return mixed
     */
    public function getDirector() {
        return $this->Director;
    }

    /**
     * @return mixed
     */
    public function getWriter() {
        return $this->Writer;
    }

    /**
     * @return mixed
     */
    public function getActors() {
        return $this->Actors;
    }

    /**
     * @return mixed
     */
    public function getPlot() {
        return $this->Plot;
    }

    /**
     * @return mixed
     */
    public function getLanguage() {
        return $this->Language;
    }

    /**
     * @return mixed
     */
    public function getCountry() {
        return $this->Country;
    }

    /**
     * @return mixed
     */
    public function getAwards() {
        return $this->Awards;
    }

    /**
     * @return mixed
     */
    public function getPoster() {
        return $this->Poster;
    }

    /**
     * @return mixed
     */
    public function getMetascore() {
        return $this->Metascore;
    }

    /**
     * @return mixed
     */
    public function getImdbRating() {
        return $this->imdbRating;
    }

    /**
     * @return mixed
     */
    public function getImdbVotes() {
        return $this->imdbVotes;
    }

    /**
     * @return mixed
     */
    public function getImdbID() {
        return $this->imdbID;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->Type;
    }

    /**
     * @return mixed
     */
    public function getResponse() {
        return $this->Response;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize() {
        return $this->toArray();
    }

    /**
     * Convert into associative array
     * @return array
     */
    public function toArray() {
        $movie_x = [];
        $properties = array_keys( get_class_vars( static::class));
        foreach( $properties as $property){
            $movie_x[$property] = $this->$property;
        }
        return $movie_x;
    }

}
