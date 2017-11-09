<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 7/25/16
 * Time: 2:50 PM
 */

namespace Classes\Helper;
use Classes\Generic\AbstractHelper;

class FileSystem extends AbstractHelper
{
    protected $config;

    protected $env;
    protected $parser;


    public function __construct(
        \Classes\Generic\AbstractHelper $env
    )
    {
        $this->parser = new \Classes\Helper\XmlParser();
        $this->env = $env;
    }

    public function getConfigurations(){

        return (object) $this->readSettings();
    }

    public function readSettings()
    {
        $result = [];
        $env = $this->env;
        $docRoot = $env->getConfigValue('project/doc_root');
        $framework = $env->getConfigValue('project/framework');
        $configFile = $env->getConfigValue('project/local_config');
        $parser = $this->parser->load($docRoot.'/'.$configFile);
        $path = $env->getConfigValue("service/$this->serviceCode/$framework/connection/path");
        $map = $env->getConfigValue("service/$this->serviceCode/$framework/connection/map");
        $result = $parser->getConfigValue($path);
        if ($map) {
            $result = $this->mapSettings($result, $map);
        }
        return $result;
    }
}
