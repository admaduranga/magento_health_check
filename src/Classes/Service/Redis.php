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

class Redis extends AbstractService implements InterfaceService
{
    /**
     * Initialize any configurations or  classes
     * @return mixed
     */
    public function init()
    {
        // TODO: Implement init() method.
        $framework = $this->env->getConfigValue('project/framework');
        switch ($framework) {
            case 'magento_1':
                $this->setConfig(new \Classes\Helper\MagentoConfig($this->env));
                break;
        }
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
            $errno = 3000;
            $errstr = 'Server Socket Cannot Be Opened';
            $fp = @stream_socket_client("tcp://$config->server:$config->port", $errno, $errstr, 30);
            if (!$fp) {
                echo "$errstr ($errno)<br />\n";
            } else {
                $output = true;
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