<?php
namespace Classes\Generic;
class AbstractService
{
    protected $serviceCode = '';
    protected $env;
    protected $config;
    protected $framework;
    /**
     * DirCheck constructor.
     * @param \Classes\Generic\AbstractHelper|null $env
     */
    public function __construct($serviceCode, \Classes\Generic\AbstractHelper $config=null)
    {
        $this->setConfig($config);
        $this->setServiceCode($serviceCode);
    }


    /**
     * Validate the response to determine service is up and running
     * @param $response
     * @return bool
     * @override
     */
    public function validateResponse($response)
    {
        $valid = false;
        if ($response) {
            $valid = true;
        }
        return $valid;
    }


    public function getServiceCode(){
        return $this->serviceCode;
    }
    public function setServiceCode($code) {
        $this->serviceCode = $code;
    }

    public function getFramework(){
        return $this->framework;
    }
    public function setFramework($code) {
        $this->framework = $code;
    }


    public function failProcess()
    {
        echo "\nProcess Cannot Continue";
        exit;
    }

    public function setEnv($env)
    {
        $this->env = $env;
    }

    public function getEnv()
    {
        return $this->env;
    }

//    public function loadConfigClass()
//    {
//        $env = $this->env;
//        $docRoot = $env->getConfigValue('project/doc_root');
//    }
    public function setConfig($config)
    {
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }
}