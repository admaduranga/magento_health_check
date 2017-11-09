<?php
require_once '../src/monitor.php';
use Classes\Monitor;

$monitor = new Monitor('internal-mysql-database');
$monitor->runCheck();