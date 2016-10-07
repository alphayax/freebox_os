<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\services\download\Download;
use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\utils\ApiResponse;
use alphayax\freebox\utils\Application;

/**
 * Class DlRssService
 * @package alphayax\freebox\os\services
 */
class DlRssService {

    /**
     * @param $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    public static function getAction( $application) {
        $apiResponse = new ApiResponse();
        $action = @$_GET['action'];
        switch( $action){

            case 'get_list':
                $apiResponse = static::getList( $apiResponse, $application);
                break;

            case 'check_from_id':
                $apiResponse = static::checkFromId( $apiResponse, $application);
                break;

            default:
                $apiResponse->setSuccess( false);
                $apiResponse->setError( "Unknown action ($action)");

        }

        return $apiResponse;
    }

    /**
     * @param ApiResponse $apiResponse
     * @param $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    private static function getList( ApiResponse $apiResponse, $application) {
        $configs = [];

        /// Scan files for configs
        $config_rfi_s = glob( __DIR__ . '/../etc/download/dl_rss/*.json');
        foreach( $config_rfi_s as $config_rfi){
            $id = basename( $config_rfi);
            $config = json_decode( file_get_contents( $config_rfi), true);
            $config['id'] = $id;
            $config['rfi'] = $config_rfi;
            $configs[] = $config;
        }

        $apiResponse->setData( $configs);

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param                                        $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    private static function checkFromId( ApiResponse $apiResponse, Application $application) {

        $return = [];
        $config = [];
        $json = json_decode( file_get_contents('php://input'), true);
        $id = $json['id'];

        /// Scan files for configs
        $config_rfi_s = glob( __DIR__ . '/../etc/download/dl_rss/*.json');
        foreach( $config_rfi_s as $config_rfi){
            $rssSearchId = basename( $config_rfi);
            if( $rssSearchId != $id ){
                continue;
            }
            $config = json_decode( file_get_contents( $config_rfi), true);
            $config['id'] = $rssSearchId;
            $config['rfi'] = $config_rfi;
        }

        if( empty( $config)){
            $apiResponse->setSuccess( false);
            $apiResponse->setError( 'Configuration non trouvee ' . var_export($id, true));
            return $apiResponse;
        }

        $freeboxMaster = Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();
        $downloadService = new Download( $application);

        $rss = simplexml_load_file( $config['rss']);
        if( ! $rss){
            $apiResponse->setSuccess( false);
            $apiResponse->setError( "Impossible de scanner le flux RSS");
            return $apiResponse;
        }
        foreach( $rss->xpath('//item') as $item){
            $title = (string) $item->xpath('title')[0];
            $date  = (string) $item->xpath('pubDate')[0];
            $link  = (string) $item->xpath('link')[0];
            $desc  = (string) $item->xpath('description')[0];
            if( preg_match( $config['pattern'], $title)){
                if( strtotime( $date) > $config['last_date']){
                    $config['last_date'] = strtotime( $date);

                    $downloadService->addFromUrl( $link);

                    $return[] = "$title ($desc)";
                }
            }
        }
        $rfi = $config['rfi'];
        unset( $config['rfi']);
        unset( $config['id']);

        file_put_contents( $rfi, json_encode( $config, JSON_PRETTY_PRINT));
        $apiResponse->setData($return);
        return $apiResponse;
    }

}
