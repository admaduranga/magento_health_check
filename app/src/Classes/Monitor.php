<?php
namespace Classes;

class Monitor
{
    protected $service;
    protected $env;
    protected $config;
    protected $messages;

    /**
     * @param bool $config
     * @return $this
     */
    public function init($config = false)
    {
        $this->config = new Helper\Config();
        $this->config->init($config);
        return $this;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return \Classes\Generic\AbstractService
     */
    public function getConfig()
    {
        return $this->config;
    }


    /**
     * @param $serviceCode
     * @return \Classes\Generic\AbstractService
     * @throws \Exception
     */
    public function initService($serviceCode)
    {
        $service = NULL;
        try {
            $serviceClass = $this->getConfig()->asObject()->service->$serviceCode->service_class;
            if ($serviceClass) {
                $service = new $serviceClass($serviceCode, $this->getConfig());
                if (!$service instanceof \Classes\Generic\AbstractService) {
                    $this->failHealthCheck('No Service Class Found. Please Specify in the Settings');
                }
            }
        } catch (\Exception $e) {
            $this->failHealthCheck($e->getMessage());
        }
        /** var $service \Classes\Generic\AbstractService */
        return $service;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function healthCheck()
    {
        try {
            $result = [];
            $config = $this->getConfig()->asObject();
            if (!$config) {
                throw new \Exception('Invalid configuration found');
            }

            foreach ($config->service as $code => $service) {
                if ($service->status) {
                    $status = $this->initService($code)->checkService();
                    if (!$status) {
                        $this->failHealthCheck("service $code failed");
                    }
                    $result[$code] = $this->initService($code)->checkService();
                }
            }
            return $result;
        } catch (\Exception $e) {
            $this->failHealthCheck($e->getMessage());
        }
    }

    public function addMessage($message, $key = '')
    {
        if (empty($key)) {
            $this->messages[] = $message;
            return true;
        }
        $this->messages[$key] = $message;
    }

    public function getMessages()
    {
        return $this->messages;
    }

    protected function failHealthCheck($msg)
    {
        $this->addMessage($msg);
        http_response_code(500);
    }
}