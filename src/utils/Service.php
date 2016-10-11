<?php
namespace alphayax\freebox\os\utils;
use alphayax\freebox\utils\Application;

/**
 * Class Service
 * @package alphayax\freebox\os\utils
 */
abstract class Service {

    /** @var \alphayax\freebox\utils\Application */
    protected $application;

    /** @var \alphayax\freebox\os\utils\ApiResponse */
    protected $apiResponse;

    /**
     * ApiResponse constructor.
     * @param \alphayax\freebox\utils\Application $application
     */
    public function __construct( Application $application){
        $this->application = $application;
        $this->apiResponse = new ApiResponse();
        $this->apiRequest  = json_decode( file_get_contents('php://input'), true);
    }

    /**
     *
     */
    abstract public function executeAction();

    /**
     * @param $action
     */
    protected function actionNotFound( $action){
        $this->apiResponse->setSuccess( false);
        $this->apiResponse->setError( "Unknown action ($action)");
    }

    /**
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    public function getApiResponse() {
        return $this->apiResponse;
    }

}
