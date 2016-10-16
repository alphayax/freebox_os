<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\models\AirMedia\AirMediaReceiverRequest;
use alphayax\freebox\api\v3\services\AirMedia\AirMediaReceiver;
use alphayax\freebox\api\v3\services\FileSystem\FileSharingLink;
use alphayax\freebox\api\v3\services\FileSystem\FileSystemListing;
use alphayax\freebox\api\v3\symbols\AirMedia\Action;
use alphayax\freebox\api\v3\symbols\AirMedia\MediaType;
use alphayax\freebox\os\etc\Config;
use alphayax\freebox\os\models\FileSystem\FileInfo;
use alphayax\freebox\os\utils\Omdb\Omdb;
use alphayax\freebox\os\utils\Service;

/**
 * Class FileSystemService
 * @package alphayax\freebox\os\services
 */
class FileSystemService extends Service {

    /**
     * @inheritdoc
     */
    public function executeAction( $action) {
        switch( $action){

            case 'synopsis' : $this->synopsis();        break;
            case 'play'     : $this->play();            break;
            case 'share'    : $this->share();           break;
            case 'explore'  : $this->explore();         break;
            default : $this->actionNotFound( $action);  break;
        }
    }

    /**
     *
     */
    protected function synopsis() {
        $movie = Omdb::search( @$_POST['movie_title']);
        $this->apiResponse->setData([
            'plot'  => $movie->getPlot(),
        ]);
    }

    /**
     *
     */
    protected function play() {

        $path = @$this->apiRequest['path'];

        $freeboxMaster = Config::get( 'assoc')[0];
        $this->application->setAppToken( $freeboxMaster['token']);
        $this->application->setFreeboxApiHost( $freeboxMaster['host']);
        $this->application->authorize();
        $this->application->openSession();

        // First, we have to share the file over the internet (It's stupid, but it's working only like that...)
        $fileShare = new FileSharingLink( $this->application);
        $share = $fileShare->create( $path);

        // Then, we launch the AirMedia Request
        $request = new AirMediaReceiverRequest();
        $request->setAction( Action::START);
        $request->setMediaType( MediaType::VIDEO);
        $request->setMedia( $share->getFullurl());

        $am = new AirMediaReceiver( $this->application);
        $sent = $am->sendRequest( 'Freebox Player', $request);

        $this->apiResponse->setData([
            'sent' => $sent,
            'path' => $path,
        ]);
    }

    /**
     *
     */
    protected function share() {

        $path = @$this->apiRequest['path'] ?: '/';
        $uid  = @$this->apiRequest['uid']  ?: 0;

        $freeboxMaster = Config::get( 'assoc')[$uid];
        $this->application->setAppToken( $freeboxMaster['token']);
        $this->application->setFreeboxApiHost( $freeboxMaster['host']);
        $this->application->authorize();
        $this->application->openSession();

        $fileShare = new FileSharingLink( $this->application);
        $share     = $fileShare->create( $path);
        $this->apiResponse->setData([
            'name'   => $share->getName(),
            'url'    => $share->getFullurl(),
            'expire' => $share->getExpire(),
        ]);
    }

    /**
     *
     */
    protected function explore() {

        $directory = @$this->apiRequest['path'] ?: '/';
        $uid       = @$this->apiRequest['uid']  ?: 0;

        $freeboxMaster = Config::get( 'assoc')[$uid];
        $this->application->setAppToken( $freeboxMaster['token']);
        $this->application->setFreeboxApiHost( $freeboxMaster['host']);
        $this->application->authorize();
        $this->application->openSession();

        $fileSystemListing    = new FileSystemListing( $this->application);
        $fileInfos = $fileSystemListing->getFilesFromDirectory( $directory);
        $return = [
            'path' => $directory,
            'path_part' => $this->getDirectoryParts( $directory),
            'files' => [],
        ];
        foreach ( $fileInfos as $fileInfo){
            if( $fileInfo->getName() == '.' || $fileInfo->getName() == '..' ){
                continue;
            }
            $fileItem = new FileInfo( $fileInfo);
            $return['files'][] = $fileItem;
        }

        $this->apiResponse->setData( $return);
    }

    /**
     * @param $directory
     * @return mixed
     */
    private function getDirectoryParts( $directory) {
        $parts  = explode( DIRECTORY_SEPARATOR, $directory);
        $path   = '';
        $return = [];
        foreach( $parts as $i => $part){
            if( empty( $part) && $i !== 0){
                continue;
            }
            $path .= $part . DIRECTORY_SEPARATOR;
            $return[] = [
                'name'  => $part,
                'path'  => $path,
            ];
        }
        $return[0]['name'] = 'Disques';
        return $return;
    }

}
