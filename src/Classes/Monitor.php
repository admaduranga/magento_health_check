<?php
namespace Classes;

class Monitor
{
    protected $service;
    protected $env;
    protected $resultDir = 'results';
    protected $config;

    public function init($config = false)
    {
        $this->config = $config ? $config : new Helper\Config();
        $this->config->init();
        //$this->initService();
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

    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig($asObject=true)
    {
        if ($asObject) {
            return (object) $this->config;
        }
        return $this->config;
    }

    public function runCheck()
    {
        $response = $this->service->runCheck();
        $this->logResponse($response, $this->service);
    }

    /**
     * @param $serviceCode
     * @return \Classes\Generic\AbstractService
     * @throws \Exception
     */
    public function initService($serviceCode)
    {
        //$service = false;
        //
        //$framework = $env->getConfigValue('project/framework');
        //$serviceClass = $this->getConfig()->getConfigValue("service/$this->serviceCode/service_class");
        try {
            $serviceClass = $this->getConfig()->asObject()->service->$serviceCode->service_class;
            if ($serviceClass) {
                $service = new $serviceClass($serviceCode, $this->getConfig());
                if (!$service instanceof \Classes\Generic\AbstractService) {
                    throw new \Exception('No Service Class Found. Please Specify in the Settings');
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Cannot initiate Service:'.$e->getMessage());
        }

        /** var $service \Classes\Generic\AbstractService */
        return $service;
    }

    public function healthCheck()
    {
        $result = [];
        $config = $this->getConfig()->asObject();

        if (!$config) {
            throw new \Exception('Invalid configuration found');
        }

        foreach ($config->service as $code => $service) {
            if ($service->status) {
                $result[$code] = $this->initService($code)->runCheck();
            }
        }
        return $result;
    }
}