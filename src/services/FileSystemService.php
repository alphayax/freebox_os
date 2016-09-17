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
use alphayax\freebox\os\models\FileSystem\FileItem;
use alphayax\freebox\os\utils\ApiResponse;
use alphayax\freebox\os\utils\Omdb\Omdb;
use alphayax\freebox\utils\Application;

/**
 * Class FileSystemService
 * @package alphayax\freebox\os\services
 */
class FileSystemService {

    public static function getAction( $application) {
        $apiResponse = new ApiResponse();
        $action = @$_GET['action'];
        switch( $action){

            case 'synopsis' :
                $movie = Omdb::search( @$_POST['movie_title']);
                $apiResponse->setData([
                    'plot'  => $movie->getPlot(),
                ]);
                break;


            case 'play':
                $path = @$_POST['path'];

                // First, we have to share the file over the internet (It's stupid, but it's working only like that...)
                $fileShare = new FileSharingLink( $application);
                $share = $fileShare->create( $path);

                // Then, we launch the AirMedia Request
                $request = new AirMediaReceiverRequest();
                $request->setAction( Action::START);
                $request->setMediaType( MediaType::VIDEO);
                $request->setMedia( $share->getFullurl());

                $am = new AirMediaReceiver( $application);
                $sent = $am->sendRequest( 'Freebox Player', $request);
                $apiResponse->setData([
                    'sent' => $sent,
                    'path' => $path,
                ]);
                break;

            case 'share':
                return static::share( $apiResponse, $application);

            case 'explore':
                return static::explore( $apiResponse, $application);

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
    protected static function share( ApiResponse $apiResponse, Application $application) {

        $freeboxMaster = Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();

        $path = @$_POST['path'];

        $fileShare = new FileSharingLink( $application);
        $share     = $fileShare->create( $path);
        $apiResponse->setData([
            'name'   => $share->getName(),
            'url'    => $share->getFullurl(),
            'expire' => $share->getExpire(),
        ]);

        return $apiResponse;
    }

    /**
     * @param \alphayax\freebox\os\utils\ApiResponse $apiResponse
     * @param \alphayax\freebox\utils\Application    $application
     * @return \alphayax\freebox\os\utils\ApiResponse
     */
    protected static function explore( ApiResponse $apiResponse, Application $application) {

        $freeboxMaster = Config::get( 'assoc')[0];
        $application->setAppToken( $freeboxMaster['token']);
        $application->setFreeboxApiHost( $freeboxMaster['host']);
        $application->authorize();
        $application->openSession();

        $directory = @$_POST['path'] ?: '/';

        $fileSystemListing    = new FileSystemListing( $application);
        $fileInfos = $fileSystemListing->getFilesFromDirectory( $directory);
        $return = [
            'path' => $directory,
            'path_part' => static::getDirectoryParts( $directory),
            'files' => [],
        ];
        foreach ( $fileInfos as $fileInfo){
            if( $fileInfo->getName() == '.' || $fileInfo->getName() == '..' ){
                continue;
            }
            $fileItem = new FileInfo( $fileInfo);
            $return['files'][] = $fileItem;
        }

        $apiResponse->setData( $return);

        return $apiResponse;
    }

    /**
     * @param $directory
     * @return mixed
     */
    private static function getDirectoryParts( $directory) {
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
