<?php

require_once '../../vendor/autoload.php';

$app = new \alphayax\freebox\utils\Application( 'com.alphayax.freebox.os', "Freebox OS (Alphayax)", '0.0.1');
$app->authorize();
$app->openSession();

$service = $_GET['service'];
switch( $service){
    case 'download' :
        $dlService    = new \alphayax\freebox\api\v3\services\download\Download( $app);
        $downloadTask = new \alphayax\freebox\os\services\DownloadService( $dlService);
        $data = $downloadTask;
        $template = 'download/list';
    break;

    case 'home' :
    default :
        $template = 'home';
        $data = [];
    break;
}

/// Rendering
$m = new \Mustache_Engine([
    'pragmas' => [\Mustache_Engine::PRAGMA_BLOCKS],
    'loader'  => new \Mustache_Loader_FilesystemLoader( __DIR__.'/../views'),
]);

echo $m->loadTemplate( $template)->render( $data);
