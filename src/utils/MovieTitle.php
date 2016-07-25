<?php
namespace alphayax\freebox\os\utils;

class MovieTitle {

    protected $rawTitle;
    protected $episode;
    protected $season;
    protected $cleanName;

    public function __construct($rawTitle) {
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

        // Try to find Season and Episode info
        $pattern = '/(.*) (S[0-9]+)(E[0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            $this->season    = intval( $rez[2]);
            $this->episode   = intval( $rez[3]);
            return;
        }

        // Try to find Season info
        $pattern = '/(.*) (S[0-9]+)/';
        if( preg_match( $pattern, $name, $rez)){
            $this->cleanName = trim( $rez[1]);
            $this->season    = intval( $rez[2]);
            return;
        }

        $this->cleanName = trim( $name);
    }

    /**
     * @return mixed
     */
    public function getEpisode() {
        return $this->episode;
    }

    /**
     * @return mixed
     */
    public function getSeason() {
        return $this->season;
    }

    /**
     * @return mixed
     */
    public function getCleanName() {
        return $this->cleanName;
    }

}
