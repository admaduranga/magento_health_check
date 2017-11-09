<?php
require_once '../lib/monitor.php';
use Classes\Monitor;

$monitor = new Monitor('internal-solr-search');
$monitor->runCheck();