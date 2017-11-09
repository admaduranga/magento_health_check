<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 8/22/16
 * Time: 12:14 PM
 */

namespace Classes\Helper;


class Config
{
    protected $config = null;
    protected $configReader;

    public function init()
    {
        $env = [];
        // ** Merge if local settings are available
        if (file_exists(DOC_ROOT . 'config.php')) {
            $settings = include DOC_ROOT . 'config.php';
            if (!empty($settings['project']['main_config'])) {
                $mainConfigFile = DOC_ROOT . 'src' . DS . $settings['project']['main_config'];
                if (file_exists($mainConfigFile)) {
                    $env = include $mainConfigFile;
                } else {
                    echo '***************'.$mainConfigFile;
                    throw new \Exception('main_config file is invalid');
                }
            }

            if ($settings) {
                $env = array_replace_recursive($settings, $env);
            }
        }

        $this->setConfig($env);
        return $this;
    }

    public function getConfigReader()
    {
        $configReader = $this->getConfigValue('project/config_reader');
        if (!$this->configReader) {
            $this->configReader = new $configReader($this);
        }
        return $this->configReader;
    }



//    public function load($path)
//    {
//        $env = '';
//        if (!empty($path)) {
//            if (file_exists($path)) {
//                $env = include $path;
//            }
//        }
//        $this->config = $env;
//        return $this;
//    }
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

    public function asObject()
    {
        return json_decode(json_encode($this->config));
    }

    public function asArray()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }
}