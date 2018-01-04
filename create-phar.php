<?php
define("WORKING_DIR", getcwd().'/');
define("DOC_ROOT", getcwd().'/app/');
define("DS", '/');

$srcRoot = DOC_ROOT;
$buildRoot = WORKING_DIR."/build";

$phar = new Phar($buildRoot . "/dms-health-check.phar",
    FilesystemIterator::CURRENT_AS_FILEINFO |     	FilesystemIterator::KEY_AS_FILENAME, "dms-health-check.phar");
$phar["index.php"] = file_get_contents($srcRoot . "/index.php");
$phar["README.md"] = file_get_contents($srcRoot . "/README.md");
//$phar["common.php"] = file_get_contents($srcRoot . "/common.php");
$phar->buildFromDirectory($srcRoot);
$phar->setStub($phar->createDefaultStub("index.php"));

//copy($srcRoot . "/config.ini", $buildRoot . "/config.ini");