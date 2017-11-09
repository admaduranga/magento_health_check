<?php
namespace Classes\Generic;

use \Classes\Helper;

class AbstractMonitor
{
    protected $service;
    protected $resultDir = 'results';
    protected $serviceCode = null;
    protected $config;

    public function __construct($serviceCode)
    {
        $this->setServiceCode($serviceCode);
    }

    public function init($config = false)
    {
        if (!$config) {
            $config = new Helper\Config();
            $this->setConfig($config->init());
            $config->setServiceCode($this->getServiceCode());
        }
        $this->initService();
        return $this;
    }

    /**
     * Log Service response and the current timestamp to a specific file
     * @param $response
     */
    public function logResponse($response)
    {
        $response = $response ? 'SUCCESS' : 'ERROR';
        try {
            $file = fopen($this->getOutputFilePath(), "w");
            fwrite($file, $response);
            fwrite($file, "\n");
            fwrite($file, time());
            fclose($file);
            echo "Process Finished.\n";
        } catch (\Exception $e) {
            echo 'Error Appeared';
        }
    }

    /**
     * Getter
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Where to write the output file
     * @return string
     */
    public function getOutputFilePath()
    {
        return WORKING_DIR . DS . $this->resultDir . DS . $this->getOutputFileName();
    }

    /**
     * Name of the file to output the service check result
     * @return string
     */
    public function getOutputFileName()
    {
        return $this->getService()->getServiceCode() . '.txt';
    }

    /**
     * @param $code
     */
    public function setServiceCode($code)
    {
        $this->serviceCode = $code;
    }

    /**
     * @return null
     */
    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->$name = $value;
        }
    }

    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    protected function initService()
    {
        
    }
}