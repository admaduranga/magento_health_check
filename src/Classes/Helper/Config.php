<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 8/22/16
 * Time: 12:14 PM
 */

namespace Classes\Helper;


class Config extends ConfigArrayParser
{
    public function init()
    {
        // ** Merge if local settings are available
        if (file_exists(DOC_ROOT . 'config.php')) {
            $settings = include DOC_ROOT . 'config.php';
            $env = [];
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
}