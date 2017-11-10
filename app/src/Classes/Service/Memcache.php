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

class Memcache extends AbstractService implements InterfaceService
{

    public function runCheck()
    {
        $config = $this->getConfig()->getConfigReader()->getConfigurations($this->getServiceCode());
        if ($config && isset($config->session_save)) {
            if ($config->session_save == 'files') {
               $output = false;
               return $this->validateResponse($output);
            }
            if ($config->session_save == 'memcache' && isset($config->session_save_path)) {
                $output = $this->checkConnection($config);
            }

        } else {
            $this->failProcess();
        }
    }

    public function checkConnection($config)
    {
        $errno = 3000;
        $errstr = 'Server Socket Cannot Be Opened';
        $output = false;

        $fp = @stream_socket_client("tcp://$config->session_save_path", $errno, $errstr, 30);
        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $output = true;
        }
        return $output;
    }

    public function validateResponse($response)
    {
        return $response;
    }
}