<?php
require_once '../lib/monitor.php';
use Classes\Monitor;

$env = new Classes\Helper\Env();

//$magentoConfig = new Classes\Helper\Magento2Config($env);
$magentoConfig = new Classes\Helper\MagentoConfig($env);

$service = new Classes\Service\Memcache($magentoConfig);
$service->setServiceCode('internal-memcache-session');
$shell = new Monitor($service);
$shell->runCheck();