<?php
require_once 'src/autoloader.php';
define("WORKING_DIR", getcwd().'/');
define("DOC_ROOT", getcwd().'/');
define("DS", '/');

use Classes\Monitor;

//$monitor = new Monitor('internal-mysql-database');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-redis-cache');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-redis-fpc');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-nfs-var');
//$monitor->init()->runCheck();

//$monitor = new Monitor('internal-nfs-media');
//$monitor->init()->runCheck();

$monitor = new Monitor('internal-solr-search');
$monitor->init()->runCheck();
