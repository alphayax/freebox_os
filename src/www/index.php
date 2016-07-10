<?php
use alphayax\freebox\os\utils\FreeboxOsApplication;

require_once '../../vendor/autoload.php';

/// Parse request and exec render
$render = (new FreeboxOsApplication)->getRender();

/// Rendering
echo $render;
