<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\services\FileSystem\FileSystemListing;
use alphayax\freebox\os\models\FileSystem\FileListing;

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

}
