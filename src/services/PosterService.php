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

        if( file_exists(  __DIR__ . '/../../../www/img/' . $title)){
            $this->apiResponse->setData( static::IMG_HOST . $title);
            return;
        }

        $poster = Poster::getFromTitle( $title);
        if( empty( $poster) || $poster == 'N/A'){
            $this->apiResponse->setData( '');
            return;
        }

        /// Download poster
        $img = file_get_contents( $poster);
        if( empty( $img)){
            trigger_error( "Poster cannot be downloaded : $poster");

            $this->apiResponse->setSuccess( false);
            $this->apiResponse->setError( 'Poster cannot be downloaded : '. $poster);

            return;
        }

        file_put_contents( __DIR__ . '/../../../www/img/' . $title, $img);    // TODO : Mettre un meilleur nom pour l'image

        $this->apiResponse->setData( static::IMG_HOST . $title);
    }

}
