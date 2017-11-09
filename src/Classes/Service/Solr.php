<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 7/22/16
 * Time: 10:49 AM
 */

namespace Classes\Service;

use Classes\Generic\AbstractService;
use Classes\Generic\InterfaceService;

class Solr extends AbstractService implements InterfaceService
{
    protected $dbHelper = null;
    /**
     * Initialize any configurations or  classes
     * @return mixed
     */
    public function init()
    {
        // TODO: Implement init() method.
        $framework = $this->framework = $this->env->getConfigValue('project/framework');
        switch ($framework) {
            case 'magento_1':
                $this->setConfig(new \Classes\Helper\MagentoConfig($this->env));
                break;
        }

        $this->dbHelper = new \Classes\Helper\DBReader($this->env);
    }

    public function runCheck()
    {
        $this->config->setServiceCode($this->serviceCode);
        $config = $this->config->getConfigurations();
        if ($config) {
            $output = $this->checkConnection($config);
            return $this->validateResponse($output);
        } else {
            $this->failProcess();
        }
    }

    public function checkConnection($config)
    {
        $output = false;
        try {
            $env = $this->env;
            $this->dbHelper->setConParam($config);

            $host = $this->config->getDBSystemConfig($this->dbHelper, $env->getConfigValue("service/$this->serviceCode/$this->framework/params/solr_host"), 0);
            $port = $this->config->getDBSystemConfig($this->dbHelper, $env->getConfigValue("service/$this->serviceCode/$this->framework/params/solr_port"), 0);

            $errno = 3000;
            $errstr = 'Server Socket Cannot Be Opened';

            if ($host && $port) {
                $fp = @stream_socket_client("tcp://$host:$port", $errno, $errstr, 30);
                if (!$fp) {
                    echo "$errstr ($errno)<br />\n";
                } else {
                    $output = true;
                }
            } else {
                //host and port are empty
                $output = false;
            }

        } catch (\Exception $e) {
            echo 'ERROR';
        }

        return $output;
    }

    public function validateResponse($response)
    {
        return $response;
    }
}