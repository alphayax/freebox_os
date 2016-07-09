<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\symbols\Download\Task\Status;
use alphayax\freebox\os\models\DownloadTask;

class DownloadService {

    /** @var DownloadTask[] */
    protected $downloadTasks = [];

    public function __construct( \alphayax\freebox\api\v3\services\download\Download $downloadService) {


        $downloadTasks = $downloadService->getAll();
        foreach ( $downloadTasks as $downloadTask){
            $task = new DownloadTask( $downloadTask);
            $this->downloadTasks['all'][] = $task;
            switch( $downloadTask->getStatus()){
                case Status::DONE :
                    $this->downloadTasks[Status::DONE][] = $task;
                    break;
                case Status::SEEDING :
                    $this->downloadTasks[Status::SEEDING][] = $task;
                    break;
                case Status::DOWNLOADING :
                    $this->downloadTasks[Status::DOWNLOADING][] = $task;
                    break;
            }
        }
    }

    public function getAll() {
        return $this->downloadTasks['all'];
    }

    public function getDone() {
        return $this->downloadTasks[Status::DONE];
    }

    public function getInProgress(){
        return $this->downloadTasks[Status::DOWNLOADING];
    }

    public function getSeeding(){
        return $this->downloadTasks[Status::SEEDING];
    }


}
