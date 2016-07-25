<?php
namespace alphayax\freebox\os\models\FileSystem;

use alphayax\freebox\os\models\FileSystem;

class FileListing {

    public $fileInfos = [];

    protected $directory;


    /**
     * @param \alphayax\freebox\api\v3\models\FileSystem\FileInfo[] $fileInfos
     */
    public function setFiles( $fileInfos) {

        foreach ( $fileInfos as $fileInfo){
            $this->fileInfos[] = new FileSystem\FileInfo( $fileInfo);
        }

    }

    public function setDirectory( $directory) {
        $this->directory = $directory;
    }

    /**
     * @return mixed
     */
    public function getDirectoryParts() {
        $parts  = explode( DIRECTORY_SEPARATOR, $this->directory);
        $path   = '';
        $return = [];
        foreach( $parts as $part){
            $path .= $part . DIRECTORY_SEPARATOR;
            $return[] = [
                'name'  => $part,
                'path'  => $path,
            ];
        }
        return $return;
    }

}
