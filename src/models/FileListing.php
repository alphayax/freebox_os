<?php
namespace alphayax\freebox\os\models;

class FileListing {

    public $fileInfos = [];

    /**
     * FileListing constructor.
     * @param \alphayax\freebox\api\v3\models\FileSystem\FileInfo[] $fileInfos
     */
    public function __construct( $fileInfos) {

        foreach ( $fileInfos as $fileInfo){
            $this->fileInfos[] = new \alphayax\freebox\os\models\FileInfo( $fileInfo);
        }

    }


}
