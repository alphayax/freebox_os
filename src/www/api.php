<?php
use alphayax\freebox\os\utils\FreeboxOsApplication;

require_once '../../vendor/autoload.php';

/// Rendering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');

/// Check request method (OPTION, HEADER, etc... will be ignored)
if( in_array( $_SERVER['REQUEST_METHOD'], ['PUT', 'DELETE', 'GET', 'POST'])){

    /// Parse request and exec action
    $action = (new FreeboxOsApplication)->getAction();

    /// Encode and print
    echo json_encode( $action);
}

