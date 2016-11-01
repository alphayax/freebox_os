<?php
namespace alphayax\freebox\os\services;
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

        $userAssoc = freebox\os\models\FreeboxAssoc::getFromUid( $uid);
        $this->application->setAppToken( $userAssoc->getAppToken());
        $this->application->setFreeboxApiHost( $userAssoc->getHost());
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

        $userAssoc = freebox\os\models\FreeboxAssoc::getFromUid( $uid);
        $this->application->setAppToken( $userAssoc->getAppToken());
        $this->application->setFreeboxApiHost( $userAssoc->getHost());
        $this->application->openSession();

        $dlService    = new freebox\api\v3\services\FileSystem\FileSharingLink( $this->application);
        $itemRemoved  = $dlService->deleteFromToken( $token);

        $this->apiResponse->setSuccess( $itemRemoved);
    }

}
