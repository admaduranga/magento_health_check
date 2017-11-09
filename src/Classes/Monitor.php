<?php
namespace Classes;

use \Classes\Generic;

class Monitor extends Generic\AbstractMonitor
{
    protected $service;
    protected $env;

    public function runCheck()
    {
        $response = $this->service->runCheck();
        $this->logResponse($response, $this->service);
    }

    public function initService()
    {
        //
        //$framework = $env->getConfigValue('project/framework');
        $serviceClass = $this->getConfig()->getConfigValue("service/$this->serviceCode/service_class");
        if ($serviceClass) {
            $service = new $serviceClass($this->getServiceCode(), $this->getConfig());
            if ($service instanceof \Classes\Generic\AbstractService) {
                $this->service = $service;
            } else {
                throw new \Exception('No Service Class Found. Please Specify in the Settings');
            }
        }
        return $this->service;
    }
}