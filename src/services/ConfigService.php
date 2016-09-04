<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\services\ApiVersion;
use alphayax\freebox\api\v3\services\login\Association;
use alphayax\freebox\api\v3\symbols as v3_symbols;
use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\utils\ApiResponse;
use alphayax\freebox\utils\Application;

/**
 * Class ConfigService
 * @package alphayax\freebox\os\services
 */
class ConfigService {

    /**
     * @param $application
     * @return mixed
     */
    public static function getAction( $application) {
        $apiResponse = new ApiResponse();
        $action = @$_GET['action'];
        switch( $action){

            case 'get_freebox':
                $apiResponse = static::getFreebox( $apiResponse, $application);
                break;

            case 'association':
                $apiResponse = static::association( $apiResponse, $application);
                break;

            default:
                $apiResponse->setSuccess( false);
                $apiResponse->setError( "Unknown action ($action)");

        }

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param \alphayax\freebox\utils\Application    $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    protected function getFreebox( ApiResponse $apiResponse, Application $application) {

        $assocConf = Config::get( 'assoc');
        $FbxInfos = [];

        // TODO : Return assocConf (without token)
        foreach ( $assocConf as $freebox){
            $FbxInfos[] = $freebox['host'];
        }

        $apiResponse->setData( $FbxInfos);

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param \alphayax\freebox\utils\Application    $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    private static function association( ApiResponse $apiResponse, Application $application) {

        $json = json_decode( file_get_contents('php://input'), true);
        $app_token  = @$json['app_token'];
        $track_id   = @$json['track_id'];
        $api_domain = @$json['api_domain'];
        $https_port = @$json['https_port'];

        /// Check parameters
        if( empty( $app_token) || empty( $track_id) || empty( $api_domain) || empty( $https_port)){
            $apiResponse->setSuccess( false);
            $apiResponse->setError( 'Requested parameters are missing');

            return $apiResponse;
        }

        /// Build Freebox URI
        $freebox_uri = 'https://'. $api_domain . ':' . $https_port;

        // TODO : Check if https is available

        $application->setAppToken( $app_token);
        $application->setFreeboxApiHost( $freebox_uri);

        /// Try to connect to the box
        try {
            $apiVersion = new ApiVersion($application);
            $maFreebox = $apiVersion->getApiVersion();
        }
        catch( \Exception $e){
            $apiResponse->setSuccess( false);
            $apiResponse->setError( $e->getMessage());

            return $apiResponse;
        }

        if( empty( $maFreebox)){
            $apiResponse->setSuccess( false);
            $apiResponse->setError( 'Unable to contact the freebox on '. $freebox_uri);

            return $apiResponse;
        }

        /// Try token
        try {
            $assoc = new Association( $application);
            $assoc->setTrackId( $track_id);

            /// Check Authorization status
            $status = $assoc->getAuthorizationStatus()['status'];
            if( $status != Association::STATUS_GRANTED){
                $apiResponse->setSuccess( false);
                $apiResponse->setError( 'Association status not valid : '. $status);

                return $apiResponse;
            }

            /// Open session
            $application->openSession();
        }
        catch( \Exception $e){
            $apiResponse->setSuccess( false);
            $apiResponse->setError( $e->getMessage());

            return $apiResponse;
        }

        /// Saving assoc
        static::saveNewAssociation( [
            'token' => $app_token,
            'host'  => $freebox_uri,
        ]);


        $permissions = [
            'explorer' => $application->hasPermission( v3_symbols\Permissions::EXPLORER),
            'download' => $application->hasPermission( v3_symbols\Permissions::DOWNLOADER),
        ];

        $apiResponse->setData( $permissions);

        return $apiResponse;
    }

    protected static function saveNewAssociation( $association_x) {
        $assocConf = Config::get( 'assoc');
        $assocConf[] = $association_x;
        Config::set( 'assoc', $assocConf);
    }

}
