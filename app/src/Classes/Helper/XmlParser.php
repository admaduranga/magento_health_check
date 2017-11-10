<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 8/22/16
 * Time: 12:14 PM
 */

namespace Classes\Helper;
use Classes\Generic\AbstractHelper;

class XmlParser extends AbstractHelper
{
    protected $config = null;
    protected $loaded = false;
    
    public function __construct($path='')
    {
        $env = '';
        if (!empty($path)) {
            if (file_exists($path)) {
                $env = include $path;
            }
        }
        return $this->config = $env;
    }

    public function load($path)
    {
        if (!empty($path)) {
            if (file_exists($path)) {
                try {
                    $xml = new \SimpleXMLElement($path, NULL, TRUE);
                    $this->config = $xml;
                    $this->loaded = true;
                } catch (\Exception $e) {
                    //TEMP Log Message
                    //@TODO: Change this temp log messages
                    echo "Cannot Locate the Config File".$this->magentoDir.DS.$this->configLocation;
                    return false;
                }
            }
        } else {
            throw new \Exception('Configuration file not found');
        }
        return $this;
    }

    public function isLoaded()
    {
        return $this->loaded;
    }

    public function getXpathValue($string = '', $map=[])
    {
        $result = [];
        try {
            $part = $this->getConfig()->xpath($string);
        } catch (\Exception $e) {

        }
        $config = isset($part[0]) ? $part[0] : false;

        if (!empty($config)) {
            foreach($config as $p => $v) {
                if ($map) {
                    if (isset($map[$p])) {
                        $result[$p] = $v->__toString();
                    }
                } else {
                    $result[$p] =$v->__toString();
                }
            }
            return $result;
        } else {
            if (is_object($config)) {
                return $config->__toString();
            }
        }
    }

    public function getConfig()
    {
        if ($this->config) {
            return $this->config;
        }
        throw new \Exception('Magento Configurations not loaded');
    }
}