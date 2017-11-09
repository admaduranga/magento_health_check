<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 7/25/16
 * Time: 2:50 PM
 */

namespace Classes\ConfigReaders;
use Classes\Generic\AbstractHelper;

class Magento extends AbstractHelper
{
    protected $config;
    protected $parser;
    protected $dbHelper;


    public function __construct(
        \Classes\Helper\Config $config
    )
    {
        $this->parser = new \Classes\Helper\XmlParser();
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
    public function getConfigurations($serviceCode){

        return (object) $this->readSettings($serviceCode);
    }

    public function readSettings($serviceCode)
    {
        $env = $this->config;
        $docRoot = $env->getConfigValue('project/doc_root');
        $framework = $env->getConfigValue('project/framework');
        $configFile = $env->getConfigValue('project/local_config');
        $parser = $this->parser->load($docRoot.'/'.$configFile);
        $path = $env->getConfigValue("service/$serviceCode/connection/path");
        $map = $env->getConfigValue("service/$serviceCode/connection/map");
        $result = $parser->getConfigValue($path);
        if ($map) {
            $result = $this->mapSettings($result, $map);
        }
        return $result;
    }

    public function getDBSystemConfig($dbHelper, $path, $store)
    {
        $conn = $dbHelper->getConnection();
        $stmt = $conn->prepare("SELECT value from core_config_data where path = :path and scope_id = :store ");
        $value = $dbHelper->getResultAsValue($stmt, [':store' => $store, ':path' => $path]);
        return $value;
    }
}
