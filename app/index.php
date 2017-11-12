<?php
require_once 'src/autoloader.php';
define("WORKING_DIR", getcwd().'/');
define("APP_ROOT", __DIR__.'/');

define("DS", '/');
define('VERSION', '0.0.1 beta');
use Classes\Monitor;

if (!empty($argv[1]) && $argv[1] == 'version') {
    echo VERSION;
    exit;
}


$config_file = false;
if (PHP_SAPI === 'cli' && !empty($argv[1])) {
    $config_file = $argv[1];
} elseif (isset($_REQUEST)) {
    $config_file = isset($config_file_path) ? $config_file_path : false;
}

if ($config_file) {
    $config = include $config_file;
} else {
    http_response_code(500);
    echo 'no configuration specified';
    exit;
}

if ($config) {
    // *** ALL GOOD - RUN THE APPLICATION ***
    $monitor = new Monitor();
    echo print_r($monitor->init($config)->healthCheck(), true);
} else {
    http_response_code(500);
    echo 'wrong configuration file';
    exit;
}

