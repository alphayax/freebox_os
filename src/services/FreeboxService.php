<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\services as v3_services;
use alphayax\freebox\api\v3\symbols as v3_symbols;
use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\models\FreeboxAssoc;
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

            case 'get_all'              : $this->getAllFromUid();      break;
            case 'get_from_uid'         : $this->getFreeboxFromUid();  break;
            case 'get_status_from_uid'  : $this->getStatusFromUid();   break;
            case 'get_permissions'      : $this->getPermissions();     break;
            case 'update_name_from_uid' : $this->updateNameFromUid();  break;
            case 'ping'                 : $this->ping();               break;
            default : $this->actionNotFound( $action);  break;
        }
    }

    /**
     *
     */
    protected function getAllFromUid() {
        $uid = @$this->apiRequest['uid'];

        $FbxInfos = FreeboxAssoc::getAllFromUid( $uid);

        $this->apiResponse->setData( $FbxInfos);
    }

    /**
     *
     */
    protected function getStatusFromUid() {
        $uid = @$this->apiRequest['uid'];

        $userAssoc = FreeboxAssoc::getFromUid( $uid);
        $this->application->setAppToken( $userAssoc->getAppToken());
        $this->application->setFreeboxApiHost( $userAssoc->getHost());
        $this->application->openSession();

        $connectionService = new v3_services\config\Connection\Connection( $this->application);
        $status = $connectionService->getStatus();

        $this->apiResponse->setData( $status);
    }

    /**
     *
     */
    protected function getFreeboxFromUid() {
        $uid = @$this->apiRequest['uid'];

        $userAssoc = FreeboxAssoc::getFromUid( $uid);

        $this->apiResponse->setData([
            'api_domain'  => $userAssoc->getApiDomain(),
            'https_port'  => $userAssoc->getHttpsPort(),
            'name'        => $userAssoc->getName(),
        ]);
    }

    /**
     *
     */
    protected function ping() {
        $uid    = @$this->apiRequest['uid'];
        $assoc  = @$this->apiRequest['assoc'];

        /// Check parameters
        if( empty( $assoc['api_domain']) || empty( $assoc['https_port']) || empty( $uid)){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( 'Requested parameters are missing');

            return;
        }

        /// Build Freebox URI
        $freebox_uri = 'https://'. $assoc['api_domain'] . ':' . $assoc['https_port'];

        $this->application->setFreeboxApiHost( $freebox_uri);

        /// Try to connect to the box
        try {
            $apiVersion = new v3_services\ApiVersion( $this->application);
            $maFreebox = $apiVersion->getApiVersion();
        }
        catch( \Exception $e){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( $e->getMessage());

            return;
        }

        $config = Config::get( 'assoc');
        @$config[$uid]['assoc']     = $assoc;
        @$config[$uid]['version']   = $maFreebox;
        Config::set( 'assoc', $config);

        $this->apiResponse->setData( $maFreebox);
    }

    protected function getPermissions() {
        $uid    = @$this->apiRequest['uid'];
        $assoc  = @$this->apiRequest['assoc'];

        if( ! empty( $assoc)){

            /// Check parameters
            if( empty( $assoc['api_domain']) || empty( $assoc['https_port']) || empty( $assoc['app_token']) || empty( $uid)){
                $this->apiResponse->setSuccess( false);
                $this->apiResponse->setError( 'Requested parameters are missing');

                return;
            }

            /// Build Freebox URI
            $freebox_uri = 'https://'. $assoc['api_domain'] . ':' . $assoc['https_port'];
            $token = $assoc['app_token'];
        } else {
            $userAssoc    = FreeboxAssoc::getFromUid( $uid);
            $freebox_uri  = $userAssoc->getHost();
            $token        = $userAssoc->getAppToken();
        }

        if( empty( $token) || empty( $freebox_uri)){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( 'Empty token or host');
            return;
        }

        $this->application->setFreeboxApiHost( $freebox_uri);
        $this->application->setAppToken( $token);

        try {
            /// Open session
            $this->application->openSession();
        }
        catch( \Exception $e){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( $e->getMessage());

            return;
        }

        $this->apiResponse->setData([
            ['name' => 'explorer', 'value' => $this->application->hasPermission( v3_symbols\Permissions::EXPLORER)],
            ['name' => 'download', 'value' => $this->application->hasPermission( v3_symbols\Permissions::DOWNLOADER)],
            ['name' => 'settings', 'value' => $this->application->hasPermission( v3_symbols\Permissions::SETTINGS)],
        ]);
    }

    /**
     *
     */
    protected function updateNameFromUid() {
        $uid  = @$this->apiRequest['uid'];
        $name = @$this->apiRequest['name'];

        $config = Config::get( 'assoc');
        @$config[$uid]['assoc']['name'] = $name;
        Config::set( 'assoc', $config);
    }

}
