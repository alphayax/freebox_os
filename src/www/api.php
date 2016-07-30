<?php
use alphayax\freebox\os\utils\FreeboxOsApplication;

require_once '../../vendor/autoload.php';

/// Parse request and exec action
$action = (new FreeboxOsApplication)->getAction();

/// Rendering
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
echo json_encode( $action);
