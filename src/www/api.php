<?php
use alphayax\freebox\os\utils\FreeboxOsApplication;

require_once '../../vendor/autoload.php';

/// Parse request and exec action
$action = (new FreeboxOsApplication)->getAction();

/// Rendering
header('Content-Type: application/json');
echo json_encode( $action);
