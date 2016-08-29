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
        $action = $_GET['action'];
        switch ( $action){

            case 'clear_done':
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
                $ok = true;
                $downloadTasks = $dlService->getAll();
                foreach( $downloadTasks as $downloadTask){
                    switch( $downloadTask->getStatus()){
                        case freebox\api\v3\symbols\Download\Task\Status::DONE :
                            $ok = $dlService->deleteFromId( $downloadTask->getId()) && $ok;
                            $response['data'][] = $downloadTask->getName();
                            break;
                    }
                }
                $response['success'] = $ok;
                return $response;


            case 'clear_id':
                $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[0];
                $application->setAppToken( $freeboxMaster['token']);
                $application->setFreeboxApiHost( $freeboxMaster['host']);
                $application->authorize();
                $application->openSession();
                $dlService  = new freebox\api\v3\services\download\Download( $application);
                $downloadTask = $dlService->getFromId( $_GET['id']);
                $ok = $dlService->deleteFromId( $downloadTask->getId());
                return [
                    'success'   => $ok,
                ];

            case 'explore':

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
                $apiResponse = new freebox\os\utils\ApiResponse( $ret);

                return $apiResponse;
        }

        return '';
    }



}
