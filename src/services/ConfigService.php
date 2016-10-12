<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\services\ApiVersion;
use alphayax\freebox\api\v3\services\login\Association;
use alphayax\freebox\api\v3\symbols as v3_symbols;
use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\utils\Service;

/**
 * Class ConfigService
 * @package alphayax\freebox\os\services
 */
class ConfigService extends Service {

    /**
     * @inheritdoc
     */
    public function executeAction() {
        $action = @$_GET['action'];
        switch( $action){

            case 'get_freebox': $this->getFreebox();    break;
            case 'association': $this->association();   break;
            default : $this->actionNotFound( $action);  break;
        }
    }

    /**
     *
     */
    protected function getFreebox() {
        $uid  = @$this->apiRequest['uid'];

        $assocConf = Config::get( 'assoc');
        $FbxInfos = [];

        // TODO : Return assocConf (without token)
        foreach ( $assocConf as $uid => $freebox){
            $FbxInfos[] = [
                "uid"   => $uid,
                "host"  => $freebox['host'],
            ];
        }

        $this->apiResponse->setData( $FbxInfos);
    }

    /**
     *
     */
    private function association() {

        $app_token  = @$this->apiRequest['app_token'];
        $track_id   = @$this->apiRequest['track_id'];
        $api_domain = @$this->apiRequest['api_domain'];
        $https_port = @$this->apiRequest['https_port'];
        $uid        = @$this->apiRequest['uid'];

        /// Check parameters
        if( empty( $app_token) || empty( $track_id) || empty( $api_domain) || empty( $https_port) || empty( $uid)){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( 'Requested parameters are missing');

            return;
        }

        /// Build Freebox URI
        $freebox_uri = 'https://'. $api_domain . ':' . $https_port;

        // TODO : Check if https is available

        $this->application->setAppToken( $app_token);
        $this->application->setFreeboxApiHost( $freebox_uri);

        /// Try to connect to the box
        try {
            $apiVersion = new ApiVersion($this->application);
            $maFreebox = $apiVersion->getApiVersion();
        }
        catch( \Exception $e){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( $e->getMessage());

            return;
        }

        if( empty( $maFreebox)){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( 'Unable to contact the freebox on '. $freebox_uri);

            return;
        }

        /// Try token
        try {
            $assoc = new Association( $this->application);
            $assoc->setTrackId( $track_id);

            /// Check Authorization status
            $status = $assoc->getAuthorizationStatus()['status'];
            if( $status != Association::STATUS_GRANTED){
                $this->apiResponse->setSuccess( false);
                $this->apiResponse->setError( 'Association status not valid : '. $status);

                return;
            }

            /// Open session
            $this->application->openSession();
        }
        catch( \Exception $e){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( $e->getMessage());

            return;
        }

        /// Saving assoc
        $this->saveNewAssociation( $uid, [
            'token' => $app_token,
            'host'  => $freebox_uri,
        ]);


        $permissions = [
            'explorer' => $this->application->hasPermission( v3_symbols\Permissions::EXPLORER),
            'download' => $this->application->hasPermission( v3_symbols\Permissions::DOWNLOADER),
        ];

        $this->apiResponse->setData( $permissions);
    }

    protected function saveNewAssociation( $uid, $association_x) {
        $assocConf = Config::get( 'assoc');
        $assocConf[$uid] = $association_x;
        Config::set( 'assoc', $assocConf);
    }

}
