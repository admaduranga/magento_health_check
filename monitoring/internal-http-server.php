<?php
require_once '../lib/monitor.php';
use Classes\Monitor;

$shell = new Monitor(new Classes\Service\Http("http://localhost"));
$shell->runCheck();