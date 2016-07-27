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
            switch( $fileInfo->getName()){
                case '.'    :
                case '..'   :
                    continue;

                default:
                    $this->fileInfos[] = new FileSystem\FileInfo( $fileInfo);
                    break;
            }
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
