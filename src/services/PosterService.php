<?php
namespace alphayax\freebox\os\services;
use alphayax\freebox\api\v3\symbols as v3_symbols;
use alphayax\freebox\os\utils\MovieTitle;
use alphayax\freebox\os\utils\Poster;
use alphayax\freebox\os\utils\Service;

/**
 * Class PosterService
 * @package alphayax\freebox\os\services
 */
class PosterService extends Service {

    // Q&D fix
    const IMG_HOST = 'http://api.freehub.ondina.alphayax.com:14789/img/';

    /**
     * @inheritdoc
     */
    public function executeAction( $action) {
        switch( $action){

            case 'get_image' : $this->getImage();       break;
            default : $this->actionNotFound( $action);  break;
        }
    }

    /**
     *
     */
    private function getImage() {
        $file_name = @$this->apiRequest['file_name'];

        $movieTitle = new MovieTitle( $file_name);
        $title = $movieTitle->getCleanName();

        $poster_url = Poster::getFromTitle( $title);

        $this->apiResponse->setData( $poster_url);
    }

}
