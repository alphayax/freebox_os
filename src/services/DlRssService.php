<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\services\download\Download;
use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\utils\Service;

/**
 * Class DlRssService
 * @package alphayax\freebox\os\services
 */
class DlRssService extends Service {

    /**
     * @inheritdoc
     */
    public function executeAction( $action) {
        switch( $action){

            case 'get_list'     : $this->getList();     break;
            case 'check_from_id': $this->checkFromId(); break;
            default : $this->actionNotFound( $action);  break;
        }
    }

    /**
     *
     */
    private function getList() {
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

        $this->apiResponse->setData( $configs);
    }

    /**
     *
     */
    private function checkFromId() {

        $return = [];
        $config = [];

        $rss_id  = @$this->apiRequest['rss_id'];
        $uid     = @$this->apiRequest['uid'];


        /// Scan files for configs
        $config_rfi_s = glob( __DIR__ . '/../etc/download/dl_rss/*.json');
        foreach( $config_rfi_s as $config_rfi){
            $rssSearchId = basename( $config_rfi);
            if( $rssSearchId != $rss_id ){
                continue;
            }
            $config = json_decode( file_get_contents( $config_rfi), true);
            $config['id'] = $rssSearchId;
            $config['rfi'] = $config_rfi;
        }

        if( empty( $config)){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( 'Configuration non trouvee ' . var_export($rss_id, true));
            return;
        }

        $freeboxMaster = Config::get( 'assoc')[$uid];
        $this->application->setAppToken( $freeboxMaster['token']);
        $this->application->setFreeboxApiHost( $freeboxMaster['host']);
        $this->application->openSession();
        $downloadService = new Download( $this->application);

        $rss = simplexml_load_file( $config['rss']);
        if( ! $rss){
            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( "Impossible de scanner le flux RSS");
            return;
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
        $this->apiResponse->setData($return);
    }

}
