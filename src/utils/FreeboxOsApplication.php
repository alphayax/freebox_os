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
        $this->application = new freebox\utils\Application( static::APP_ID, static::APP_NAME, static::APP_VERSION);
    }

    /**
     * Service Factory
     * @param $service
     * @return Service
     * @throws \Exception
     */
    protected function getService( $service) {
        switch( $service){

            case 'config'         : return new freebox\os\services\ConfigService( $this->application);
            case 'download'       : return new freebox\os\services\DownloadService( $this->application);
            case 'filesystem'     : return new freebox\os\services\FileSystemService( $this->application);
            case 'download_dlrss' : return new freebox\os\services\DlRssService( $this->application);
            default : throw new \Exception( 'Unknown service : '. $service);
        }
    }

    /**
     * For API
     */
    public function getAction() {
        $service = $_GET['service'];

        /*
        switch( $service){

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

            default:
                return [];
        }*/

        $service = $this->getService( $service);
        $service->executeAction();

        return $service->getApiResponse();
    }

}
