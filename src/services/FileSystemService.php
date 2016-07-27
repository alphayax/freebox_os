<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\models\AirMedia\AirMediaReceiverRequest;
use alphayax\freebox\api\v3\services\AirMedia\AirMediaReceiver;
use alphayax\freebox\api\v3\services\FileSystem\FileSharingLink;
use alphayax\freebox\api\v3\services\FileSystem\FileSystemListing;
use alphayax\freebox\api\v3\symbols\AirMedia\Action;
use alphayax\freebox\api\v3\symbols\AirMedia\MediaType;
use alphayax\freebox\os\models\FileSystem\FileListing;
use alphayax\freebox\os\utils\ApiResponse;
use alphayax\freebox\os\utils\Omdb\Omdb;

/**
 * Class FileSystemService
 * @package alphayax\freebox\os\services
 */
class FileSystemService {


    public static function getRender( $application) {

        $directory = @$_GET['path'] ?: '/';

        $fileSystemListing    = new FileSystemListing( $application);
        $fileInfos = $fileSystemListing->getFilesFromDirectory( $directory);

        $directoryContent = new FileListing();
        $directoryContent->setDirectory( $directory);
        $directoryContent->setFiles( $fileInfos);

        return $directoryContent;
    }

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
                $path = @$_POST['path'];

                // First, we have to share the file over the internet (It's stupid, but it's working only like that...)
                $fileShare = new FileSharingLink( $application);
                $share     = $fileShare->create( $path);
                $apiResponse->setData([
                    'name'   => $share->getName(),
                    'url'    => $share->getFullurl(),
                    'expire' => $share->getExpire(),
                ]);
                break;


            default:
                $apiResponse->setSuccess( false);
                $apiResponse->setError( "Unknown action ($action)");
        }


        return $apiResponse;
    }

}
