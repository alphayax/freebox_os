<?php
namespace alphayax\freebox\os\utils;
use \alphayax\freebox;
use Firebase\FirebaseLib;

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
        $this->application = new freebox\utils\Application( static::APP_ID, static::APP_NAME, static::APP_VERSION);
 //       $this->application->authorize();
   //     $this->application->openSession();
    }

    /**
     * For index.php
     */
    public function getRender() {

        $service = @$_GET['service'];
        switch( $service){

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

            case 'config' :
                return freebox\os\services\ConfigService::getAction( $this->application);

            case 'download' :
                return freebox\os\services\DownloadService::getAction( $this->application);

            case 'download_dlrss':
                return freebox\os\services\DlRssService::getAction( $this->application);

            case 'filesystem' :
                return freebox\os\services\FileSystemService::getAction( $this->application);
/*
            case 'test':
                $token = $_POST['token'];
                $DEFAULT_PATH = '/firebase/example';
                $firebase = new FirebaseLib('https://freebox-os.firebaseio.com/', $token);

                $test = array(
                    "foo" => "bar",
                    "i_love" => "lamp",
                    "id" => 42
                );
                $dateTime = new \DateTime();
                $firebase->set($DEFAULT_PATH . '/' . $dateTime->format('c'), $test);

                $firebase->set($DEFAULT_PATH . '/name/contact001', "John Doe");

                $name = $firebase->get($DEFAULT_PATH . '/name/contact001');
                return $name;
*/
        }

        return $data;
    }

}
