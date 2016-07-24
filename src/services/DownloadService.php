<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\symbols\Download\Task\Status;
use alphayax\freebox;


class DownloadService {

    public static function getRender( $application) {

        $dlService    = new freebox\api\v3\services\download\Download( $application);
        $downloadTasks = $dlService->getAll();
        return new freebox\os\models\DownloadTasks( $downloadTasks);
    }


    /**
     * @param $application
     * @return mixed
     */
    public static function getAction( $application) {

        $action = $_GET['action'];
        switch ( $action){

            case 'clear_done':
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
                $dlService  = new freebox\api\v3\services\download\Download( $application);
                $downloadTask = $dlService->getFromId( $_GET['id']);
                $ok = $dlService->deleteFromId( $downloadTask->getId());
                return [
                    'success'   => $ok,
                ];
        }

        return '';
    }

}
