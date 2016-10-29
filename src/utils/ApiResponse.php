<?php
namespace alphayax\freebox\os\utils;

/**
 * Class ApiResponse
 * @package alphayax\freebox\os\utils
 */
class ApiResponse implements \JsonSerializable {

    protected $success  = true;
    protected $error    = '';
    protected $data     = [];

    /** @var int */
    protected $startTime;

    /**
     * ApiResponse constructor.
     * @param array $data
     */
    public function __construct( array $data = []){
        $this->startTime = microtime( true);
        $this->data = $data;
    }

    /**
     * @param array|\JsonSerializable $data
     */
    public function setData( $data) {
        $this->data = $data;
    }

    /**
     * @param boolean $success
     */
    public function setSuccess( $success) {
        $this->success = $success;
    }

    /**
     * @param string $error
     */
    public function setError( $error) {
        $this->error = $error;
    }

    /**
     * Compute the time to perform the api request
     * @return int
     */
    protected function computeElapsedTime() {
        return microtime( true) - $this->startTime;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize() {
        if( $this->success){
            return [
                'success'   => true,
                'data'      => $this->data,
                'time'      => $this->computeElapsedTime(),
            ];
        }
        return [
            'success'   => false,
            'error'     => $this->error,
            'time'      => $this->computeElapsedTime(),
        ];
    }

}
