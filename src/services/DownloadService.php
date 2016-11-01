<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\symbols\Download\Task\Status;
use alphayax\freebox;

/**
 * Class DownloadService
 * @package alphayax\freebox\os\services
 */
class DownloadService extends freebox\os\utils\Service {

    /**
     * @inheritdoc
     */
    public function executeAction( $action) {
        switch ( $action){

            case 'clear_done'   : $this->clearDone();    break;
            case 'clear_id'     : $this->clearFromId();  break;
            case 'update_id'    : $this->updateFromId(); break;
            case 'explore'      : $this->explore();      break;
            default : $this->actionNotFound( $action);   break;
        }
    }

    /**
     * Remove downloads marked as "done"
     */
    public function clearDone() {

        $uid = @$this->apiRequest['uid'];

        $userAssoc = freebox\os\models\FreeboxAssoc::getFromUid( $uid);
        $this->application->setAppToken( $userAssoc->getAppToken());
        $this->application->setFreeboxApiHost( $userAssoc->getHost());
        $this->application->openSession();

        $cleanedTaskIds = [];
        $isSuccess = true;

        $dlService  = new freebox\api\v3\services\download\Download( $this->application);
        $downloadTasks = $dlService->getAll();
        foreach( $downloadTasks as $downloadTask){
            switch( $downloadTask->getStatus()){
                case freebox\api\v3\symbols\Download\Task\Status::DONE :
                    $isSuccess = $dlService->deleteFromId( $downloadTask->getId()) && $isSuccess;
                    $cleanedTaskIds[] = $downloadTask->getId();
                    break;
            }
        }
        $this->apiResponse->setSuccess( $isSuccess);
        $this->apiResponse->setData( $cleanedTaskIds);
    }

    /**
     * Remove a download with a specific id
     */
    public function clearFromId() {
        $uid        = @$this->apiRequest['uid'];
        $downloadId = @$this->apiRequest['id'];

        $userAssoc = freebox\os\models\FreeboxAssoc::getFromUid( $uid);
        $this->application->setAppToken( $userAssoc->getAppToken());
        $this->application->setFreeboxApiHost( $userAssoc->getHost());
        $this->application->openSession();


        $dlService  = new freebox\api\v3\services\download\Download( $this->application);
        $downloadTask = $dlService->getFromId( $downloadId);
        $isSuccess = $dlService->deleteFromId( $downloadTask->getId());
        $this->apiResponse->setSuccess( $isSuccess);
        $this->apiResponse->setData( $this->taskToDownloadItem( $downloadTask));
    }

    /**
     * Update the status of a download with a specific id
     */
    public function updateFromId() {

        $uid        = @$this->apiRequest['uid'];
        $downloadId = @$this->apiRequest['id'];
        $status     = @$this->apiRequest['status'];

        $userAssoc = freebox\os\models\FreeboxAssoc::getFromUid( $uid);
        $this->application->setAppToken( $userAssoc->getAppToken());
        $this->application->setFreeboxApiHost( $userAssoc->getHost());
        $this->application->openSession();

        $dlService  = new freebox\api\v3\services\download\Download( $this->application);
        $downloadTask = $dlService->getFromId( $downloadId);

        switch( $status){
            case 'pause'    : $downloadTask->setStatus( Status::STOPPED);       break;
            case 'download' : $downloadTask->setStatus( Status::DOWNLOADING);   break;
            case 'retry'    : $downloadTask->setStatus( Status::RETRY);         break;
        }

        $isSuccess = $dlService->update( $downloadTask);
        $this->apiResponse->setSuccess( $isSuccess);
        $this->apiResponse->setData( $this->taskToDownloadItem( $downloadTask));
    }

    /**
     * Get all the download
     */
    public function explore() {

        $uid = @$this->apiRequest['uid'];

        $userAssoc = freebox\os\models\FreeboxAssoc::getFromUid( $uid);
        $this->application->setAppToken( $userAssoc->getAppToken());
        $this->application->setFreeboxApiHost( $userAssoc->getHost());
        $this->application->openSession();

        $dlService    = new freebox\api\v3\services\download\Download( $this->application);
        $downloadTasks = $dlService->getAll();

        $ret = [];
        foreach ($downloadTasks as $downloadTask){
            $ret[] = $this->taskToDownloadItem( $downloadTask);
        }

        $this->apiResponse->setData( $ret);
    }

    /**
     * @param \alphayax\freebox\api\v3\models\Download\Task $task
     * @return \alphayax\freebox\os\models\Download\DownloadItem
     */
    protected function taskToDownloadItem( freebox\api\v3\models\Download\Task $task) {
        return new freebox\os\models\Download\DownloadItem( $task);
    }

}
