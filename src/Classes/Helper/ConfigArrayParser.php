<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 8/22/16
 * Time: 12:14 PM
 */

namespace Classes\Helper;
use Classes\Generic\AbstractHelper;

class ConfigArrayParser extends AbstractHelper
{
    protected $config = null;
    protected $configReader;

    public function load($path)
    {
        $env = '';
        if (!empty($path)) {
            if (file_exists($path)) {
                $env = include $path;
            }
        }
        $this->config = $env;
        return $this;
    }
    public function getConfigValue($string = '')
    {
        $result = $this->config;
        $string = trim($string, '/');
        $pathArr = explode('/', $string);
        if ($pathArr) {
            foreach ($pathArr as $key => $val) {
                $result = isset($result[$val]) ? $result[$val] : false;
                if ($result === false) {
                    return false;
                }
            }
        }
        return $result;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }
}