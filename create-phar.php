<?php
define("WORKING_DIR", getcwd().'/');
define("DOC_ROOT", getcwd().'/');
define("DS", '/');

$srcRoot = DOC_ROOT;
$buildRoot = DOC_ROOT."/build";

$phar = new Phar($buildRoot . "/ns-app-monitor.phar",
    FilesystemIterator::CURRENT_AS_FILEINFO |     	FilesystemIterator::KEY_AS_FILENAME, "ns-app-monitor.phar");
$phar["index.php"] = file_get_contents($srcRoot . "/index.php");
//$phar["common.php"] = file_get_contents($srcRoot . "/common.php");
$phar->buildFromDirectory($srcRoot);
$phar->setStub($phar->createDefaultStub("index.php"));

//copy($srcRoot . "/config.ini", $buildRoot . "/config.ini");