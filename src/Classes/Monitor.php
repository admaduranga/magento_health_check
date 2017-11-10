<?php
namespace Classes;

class Monitor
{
    protected $service;
    protected $env;
    protected $config;

    /**
     * @param bool $config
     * @return $this
     */
    public function init($config = false)
    {
        $this->config = $config ? $config : new Helper\Config();
        $this->config->init();
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
                    throw new \Exception('No Service Class Found. Please Specify in the Settings');
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Cannot initiate Service:'.$e->getMessage());
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
                    $result[$code] = $this->initService($code)->runCheck();
                }
            }
            return $result;
        } catch (\Exception $e) {
            echo json_encode(['status' => '500', 'msg' => $e->getMessage()]);
            http_response_code(500);
        }


    }
}