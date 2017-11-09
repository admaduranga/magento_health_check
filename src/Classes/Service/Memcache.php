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
//    /**
//     * @var string
//     */
//    protected $serviceCode = 'internal-memcache-session';
//
//    /**
//     * THis is a test function
//     * @var \Classes\Helper\MagentoConfig
//     */
//    protected $config;
//
//    /**
//     * MySql constructor.
//     * @param \Classes\Helper\MagentoConfig $config
//     */
//    public function __construct(\Classes\Generic\AbstractHelper $config)
//    {
//        $this->config = $config;
//    }


    public function runCheck()
    {
        //$this->config->setServiceCode($this->serviceCode);
        //$config = $this->config->getConfigurations();
        $config = $this->getConfig()->getConfigReader()->getConfigurations();
        if ($config) {
            if (isset($config->scalar) &&  $config->scalar == 'files') {
               $output = false;
            } else {
                $output = $this->checkConnection($config);
            }
            return $this->validateResponse($output);
        } else {
            $this->failProcess();
        }
    }

    public function checkConnection($config)
    {
        $errno = 3000;
        $errstr = 'Server Socket Cannot Be Opened';
        $fp = @stream_socket_client("tcp://$config", $errno, $errstr, 30);
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