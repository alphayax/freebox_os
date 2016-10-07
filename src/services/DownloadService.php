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

            case 'update_id':
                return static::updateFromId( $apiResponse, $application);

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

        $cleanedTasks = [];
        $isSuccess = true;

        $dlService  = new freebox\api\v3\services\download\Download( $application);
        $downloadTasks = $dlService->getAll();
        foreach( $downloadTasks as $downloadTask){
            switch( $downloadTask->getStatus()){
                case freebox\api\v3\symbols\Download\Task\Status::DONE :
                    $isSuccess = $dlService->deleteFromId( $downloadTask->getId()) && $isSuccess;
                    $cleanedTasks[] = $downloadTask->getName();
                    break;
            }
        }
        $apiResponse->setSuccess( $isSuccess);
        $apiResponse->setData( $cleanedTasks);
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

        $json = json_decode( file_get_contents('php://input'), true);
        $downloadId = @$json['id'];

        $dlService  = new freebox\api\v3\services\download\Download( $application);
        $downloadTask = $dlService->getFromId( $downloadId);
        $isSuccess = $dlService->deleteFromId( $downloadTask->getId());
        $apiResponse->setSuccess( $isSuccess);
        $apiResponse->setData( static::taskToDownloadItem( $downloadTask));

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param \alphayax\freebox\utils\Application    $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    public static function updateFromId(freebox\os\utils\ApiResponse $apiResponse, freebox\utils\Application $application) {
        $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();

        $json = json_decode( file_get_contents('php://input'), true);
        $downloadId = @$json['id'];
        $status     = @$json['status'];


        $dlService  = new freebox\api\v3\services\download\Download( $application);
        $downloadTask = $dlService->getFromId( $downloadId);

        switch( $status){
            case 'pause'    : $downloadTask->setStatus( Status::STOPPED);       break;
            case 'download' : $downloadTask->setStatus( Status::DOWNLOADING);   break;
        }

        $isSuccess = $dlService->update( $downloadTask);
        $apiResponse->setSuccess( $isSuccess);
        $apiResponse->setData( static::taskToDownloadItem( $downloadTask));

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
            $ret[] = static::taskToDownloadItem( $downloadTask);
        }

        $apiResponse->setData( $ret);

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\api\v3\models\Download\Task $task
     * @return \alphayax\freebox\os\models\Download\DownloadItem
     */
    protected static function taskToDownloadItem( freebox\api\v3\models\Download\Task $task) {
        $dl = new freebox\os\models\Download\DownloadItem( $task);
        $dl->init();
        return $dl;
    }



}
