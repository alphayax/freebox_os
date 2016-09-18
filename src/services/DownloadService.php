<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\symbols\Download\Task\Status;
use alphayax\freebox;

/**
 * Class DownloadService
 * @package alphayax\freebox\os\services
 */
class DownloadService {

    /**
     * @param $application
     * @return mixed
     */
    public static function getAction( freebox\utils\Application $application) {
        $apiResponse = new freebox\os\utils\ApiResponse();
        $action = $_GET['action'];
        switch ( $action){

            case 'clear_done':
                return static::clearDone( $apiResponse, $application);

            case 'clear_id':
                return static::clearFromId( $apiResponse, $application);

            case 'pause_id':
                return static::pauseFromId( $apiResponse, $application);

            case 'explore':
                return static::explore( $apiResponse, $application);

            default:
                $apiResponse->setSuccess( false);
                $apiResponse->setError( "Unknown action ($action)");
        }

        return $apiResponse;
    }

    public static function clearDone( freebox\os\utils\ApiResponse $apiResponse, freebox\utils\Application $application) {
        $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();
        $dlService  = new freebox\api\v3\services\download\Download( $application);
        $response = [
            'success'   => true,
            'data'      => [],
        ];
        $isSuccess = true;
        $downloadTasks = $dlService->getAll();
        foreach( $downloadTasks as $downloadTask){
            switch( $downloadTask->getStatus()){
                case freebox\api\v3\symbols\Download\Task\Status::DONE :
                    $isSuccess = $dlService->deleteFromId( $downloadTask->getId()) && $isSuccess;
                    $response['data'][] = $downloadTask->getName();
                    break;
            }
        }
        $apiResponse->setSuccess( $isSuccess);
        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param \alphayax\freebox\utils\Application    $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    public static function clearFromId( freebox\os\utils\ApiResponse $apiResponse, freebox\utils\Application $application) {
        $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();

        $dlService  = new freebox\api\v3\services\download\Download( $application);
        $downloadTask = $dlService->getFromId( $_GET['id']);
        $isSuccess = $dlService->deleteFromId( $downloadTask->getId());
        $apiResponse->setSuccess( $isSuccess);

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param \alphayax\freebox\utils\Application    $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    public static function pauseFromId( freebox\os\utils\ApiResponse $apiResponse, freebox\utils\Application $application) {
        $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();

        $dlService  = new freebox\api\v3\services\download\Download( $application);
        $downloadTask = $dlService->getFromId( $_GET['id']);
        $downloadTask->setStatus( Status::DOWNLOADING);

        $isSuccess = $dlService->update( $downloadTask);
        $apiResponse->setSuccess( $isSuccess);

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param \alphayax\freebox\utils\Application    $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    public static function explore( freebox\os\utils\ApiResponse $apiResponse, freebox\utils\Application $application) {

        $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();

        $dlService    = new freebox\api\v3\services\download\Download( $application);
        $downloadTasks = $dlService->getAll();

        $ret = [];
        foreach ($downloadTasks as $downloadTask){
            $dl = new freebox\os\models\Download\DownloadItem( $downloadTask);
            $dl->init();
            $ret[] = $dl;
        }

        $apiResponse->setData( $ret);

        return $apiResponse;
    }



}
