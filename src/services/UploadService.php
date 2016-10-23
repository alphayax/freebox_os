<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\symbols\Download\Task\Status;
use alphayax\freebox;

/**
 * Class UploadService
 * @package alphayax\freebox\os\services
 */
class UploadService extends freebox\os\utils\Service {

    /**
     * @inheritdoc
     */
    public function executeAction( $action) {
        switch ( $action){

            case 'get_all'              : $this->getAll();          break;
            case 'delete_from_token'    : $this->deleteFromToken(); break;
            default : $this->actionNotFound( $action);              break;
        }
    }

    /**
     *
     */
    public function getAll() {

        $uid = @$this->apiRequest['uid'];

        $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[$uid];
        $this->application->setAppToken( $freeboxMaster['token']);
        $this->application->setFreeboxApiHost( $freeboxMaster['host']);
        $this->application->openSession();

        $dlService    = new freebox\api\v3\services\FileSystem\FileSharingLink( $this->application);
        $downloadTasks = $dlService->getAll();

        $this->apiResponse->setData( $downloadTasks);
    }

    /**
     *
     */
    public function deleteFromToken() {
        $uid    = @$this->apiRequest['uid'];
        $token  = @$this->apiRequest['token'];

        $freeboxMaster = freebox\os\etc\Config::get( 'assoc')[$uid];
        $this->application->setAppToken( $freeboxMaster['token']);
        $this->application->setFreeboxApiHost( $freeboxMaster['host']);
        $this->application->openSession();

        $dlService    = new freebox\api\v3\services\FileSystem\FileSharingLink( $this->application);
        $itemRemoved  = $dlService->deleteFromToken( $token);

        $this->apiResponse->setSuccess( $itemRemoved);
    }

}
