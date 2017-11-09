<?php
require_once 'src/autoloader.php';
define("WORKING_DIR", getcwd().'/');
define("DOC_ROOT", getcwd().'/');
define("DS", '/');

use Classes\Monitor;

$monitor = new Monitor('internal-mysql-database');
$monitor->init()->runCheck();