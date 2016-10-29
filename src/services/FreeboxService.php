<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\services as v3_services;
use alphayax\freebox\api\v3\symbols as v3_symbols;
use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\utils\Service;

/**
 * Class FreeboxService
 * @package alphayax\freebox\os\services
 */
class FreeboxService extends Service {

    /**
     * @inheritdoc
     */
    public function executeAction( $action) {
        switch( $action){

            case 'get_from_uid'         : $this->getFreeboxFromUid();  break;
            case 'get_status_from_uid'  : $this->getStatusFromUid();   break;
            default : $this->actionNotFound( $action);  break;
        }
    }

    /**
     *
     */
    protected function getStatusFromUid() {
        $uid = @$this->apiRequest['uid'];

        $freeboxMaster = Config::get( 'assoc')[$uid];
        $this->application->setAppToken( $freeboxMaster['token']);
        $this->application->setFreeboxApiHost( $freeboxMaster['host']);
        $this->application->openSession();

        $connectionService = new v3_services\config\Connection\Connection( $this->application);
        $status = $connectionService->getStatus();

        $this->apiResponse->setData( $status);
    }

    /**
     *
     */
    protected function getFreeboxFromUid() {
        $_SESSION['uid']  = @$this->apiRequest['uid'];

        $assocConf = Config::get( 'assoc');

        $this->apiResponse->setData([
            'uid'   => @$this->apiRequest['uid'],
            'host'  => @$assocConf['uid']['host'],
        ]);
    }

}
