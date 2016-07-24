<?php
namespace alphayax\freebox\os\models;
use alphayax\freebox\api\v3\symbols\Download\Task\Status;
use alphayax\freebox;


class DownloadTasks {

    /** @var DownloadTask[] */
    protected $downloadTasks = [
        'all'               => [],
        Status::DONE        => [],
        Status::SEEDING     => [],
        Status::DOWNLOADING => [],
    ];

    public function __construct( $downloadTasks) {

        /** @var freebox\api\v3\models\Download\Task $downloadTask */
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
