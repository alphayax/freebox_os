<?php
namespace alphayax\freebox\os\models;
use alphayax\freebox\os\etc\Config;

/**
 * Class FreeboxAssoc
 * @package alphayax\freebox\os\models
 */
class FreeboxAssoc {

    /** @var string */
    protected $api_domain;

    /** @var int */
    protected $https_port;

    /** @var string */
    protected $name;

    /** @var string */
    protected $app_token;

    /** @var string */
    protected $track_id;

    /**
     * Freebox constructor.
     * @param array $data
     */
    public function __construct( $data = []) {
        $this->api_domain = @$data['api_domain'];
        $this->https_port = @$data['https_port'];
        $this->name       = @$data['name'];
        $this->app_token  = @$data['app_token'];
        $this->track_id   = @$data['track_id'];
    }

    /**
     * @param string $uid
     * @return \alphayax\freebox\os\models\FreeboxAssoc
     */
    public static function getFromUid( $uid) {
        $freeboxAssoc = Config::get( 'assoc');
        $userAssoc_x  = @$freeboxAssoc[$uid]['assoc'] ?: [];
        return new static( $userAssoc_x);
    }

    /**
     * Get all freeboxes for the given user
     * @todo This feature is not fully implemented : All freeboxes are returned
     * @param $uid
     * @return array
     */
    public static function getAllFromUid( $uid) {
        $freeboxAssoc = Config::get( 'assoc');
        $freeboxes = [];

        foreach( $freeboxAssoc as $box_uid => $freebox){
            $box = new static( $freebox['assoc']);
            $freeboxes[] = [
                'name'  => $box->getName(),
                'uid'   => $box_uid,
            ];
        }

        return $freeboxes;
    }


    /**
     * @return string
     */
    public function getApiDomain() {
        return $this->api_domain;
    }

    /**
     * @return int
     */
    public function getHttpsPort() {
        return $this->https_port;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName( $name) {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAppToken() {
        return $this->app_token;
    }

    /**
     * @return string
     */
    public function getTrackId() {
        return $this->track_id;
    }

    /**
     * @return string
     */
    public function getHost() {
        return 'https://' . $this->api_domain . ':' . $this->https_port;
    }
}
