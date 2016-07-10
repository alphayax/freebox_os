<?php
namespace alphayax\freebox\os\services;

/**
 * Class DlRssService
 * @package alphayax\freebox\os\services
 */
class DlRssService {

    protected $downloadService;
    protected $configs = [];

    public function __construct(\alphayax\freebox\api\v3\services\download\Download $downloadService) {

        $this->downloadService = $downloadService;

        /// Scan files for configs
        $config_rfi_s = glob( __DIR__ . '/../etc/download/dl_rss/*.json');
        foreach( $config_rfi_s as $config_rfi){
            $id = basename( $config_rfi);
            $config = json_decode( file_get_contents( $config_rfi), true);
            $config['id'] = $id;
            $config['rfi'] = $config_rfi;
            $this->configs[] = $config;
        //    $config = $this->checkRSS( $config);
        //    file_put_contents( $config_rfi, json_encode( $config, JSON_PRETTY_PRINT));
        }
    }

    public function getConfigs() {
        return $this->configs;
    }

    public function check() {
        $return = [];
        $id = $_POST['id'];
        $found = false;
        foreach( $this->configs as $config){
            if( $config['id'] == $id){
                $found = true;
                break;
            }
        }
        if( ! $found){
            return [];
        }
        $rss = simplexml_load_file( $config['rss']);
        foreach( $rss->xpath('//item') as $item){
            $title = (string) $item->xpath('title')[0];
            $date  = (string) $item->xpath('pubDate')[0];
            $link  = (string) $item->xpath('link')[0];
            $desc  = (string) $item->xpath('description')[0];
            if( preg_match( $config['pattern'], $title)){
                if( strtotime( $date) > $config['last_date']){
                    $config['last_date'] = strtotime( $date);

                    $this->downloadService->addFromUrl( $link);

                    $return[] = "$title ($desc)";
                }
            }
        }
        $rfi = $config['rfi'];
        unset( $config['rfi']);
        unset( $config['id']);
        file_put_contents( $rfi, json_encode( $config, JSON_PRETTY_PRINT));
        return $return;
    }
}
