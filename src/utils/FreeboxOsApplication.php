<?php
namespace alphayax\freebox\os\utils;
use \alphayax\freebox;

/**
 * Class FreeboxOsApplication
 * @package alphayax\freebox\os\utils
 */
class FreeboxOsApplication {

    const APP_ID        = 'com.alphayax.freebox.os';
    const APP_NAME      = 'Freebox OS (Alphayax)';
    const APP_VERSION   = '0.0.1';

    /** @var freebox\utils\Application */
    protected $application;


    /**
     * FreeboxOsApplication constructor.
     */
    public function __construct() {
        $this->application = new freebox\utils\Application(static::APP_ID, static::APP_NAME, static::APP_VERSION);
        $this->application->authorize();
        $this->application->openSession();
    }

    /**
     * For index.php
     */
    public function getRender() {

        $service = $_GET['service'];
        switch( $service){

            case 'download' :
                $dlService    = new freebox\api\v3\services\download\Download( $this->application);
                $downloadTask = new freebox\os\services\DownloadService( $dlService);
                $data = $downloadTask;
                $template = 'download/list';
                break;

            case 'download_dlrss':
                $dlService    = new freebox\api\v3\services\download\Download( $this->application);
                $dlRss        = new freebox\os\services\DlRssService( $dlService);
                $data = $dlRss;
                $template = 'download/dl_rss';
                break;

            case 'home' :
            default :
                $template = 'home';
                $data = [];
                break;
        }

        /// Rendering
        $m = new \Mustache_Engine([
            'pragmas' => [\Mustache_Engine::PRAGMA_BLOCKS],
            'loader'  => new \Mustache_Loader_FilesystemLoader( __DIR__.'/../views'),
        ]);

        return $m->loadTemplate( $template)->render( $data);
    }

    /**
     * For API
     */
    public function getAction() {
        $service = $_GET['service'];
        $data = [];
        switch( $service){

            case 'download_dlrss':
                $dlService  = new freebox\api\v3\services\download\Download( $this->application);
                $dlRss      = new freebox\os\services\DlRssService( $dlService);
                $data = $dlRss->check();
                break;
        }

        return $data;
    }

}
