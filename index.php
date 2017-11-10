<?php
require_once 'src/autoloader.php';
define("WORKING_DIR", getcwd().'/');
define("DOC_ROOT", getcwd().'/');
define("DS", '/');

use Classes\Monitor;
register_shutdown_function("fatalErrorHandler");

$monitor = new Monitor();
echo print_r($monitor->init()->healthCheck(), true);



//$monitor = new Monitor('internal-redis-cache');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-redis-fpc');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-nfs-var');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-nfs-media');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-solr-search');
//$monitor->init()->runCheck();

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