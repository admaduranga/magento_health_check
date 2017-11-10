<?php
require_once 'src/autoloader.php';
define("WORKING_DIR", getcwd().'/');
define("DOC_ROOT", getcwd().'/');
define("DS", '/');
echo get_include_path();exit;
use Classes\Monitor;

if (empty($argv[1])) {
    http_response_code(500);
    echo 'no configuration specified';
    exit;
} else {
    $config = include $argv[1];
}

$monitor = new Monitor();
echo print_r($monitor->init($config)->healthCheck(), true);

/**
 * Handle any fatal errors
 *
 * @return void
 */
function fatalErrorHandler()
{
    $error = error_get_last();
    if ($error !== null) {
        echo json_encode($error);
        http_response_code(500);
    }
}

