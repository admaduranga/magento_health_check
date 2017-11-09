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

class DirCheck extends AbstractService implements InterfaceService
{
    /**
     * @var string
     */
    protected $serviceCode = 'internal-redis-cache';

    /**
     * THis is a test function
     * @var \Classes\Helper\MagentoConfig
     */
    protected $config;

    public function init()
    {
        //
    }

    public function runCheck()
    {
        //$this->config->setServiceCode($this->serviceCode);
        $env = $this->env;
        $docRoot = $env->getConfigValue('project/doc_root');
        $framework = $env->getConfigValue('project/framework');
        $path = $env->getConfigValue("service/$this->serviceCode/$framework/dir_path");

        $dir_path = $docRoot.$path;

        //$config = $this->config->getConfigurations();
        if ($dir_path) {
            $output = $this->checkConnection($dir_path);
            return $this->validateResponse($output);
        } else {
            $this->failProcess();
        }
    }

    public function checkConnection($dir_path)
    {
        try {
            $output = shell_exec("ls -al $dir_path");
            if ($output) {
                $exitCode = shell_exec("echo $?");
                if (trim($exitCode) == "0") {
                    $output = true;
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        return $output;
    }

    public function validateResponse($response)
    {
        return $response;
    }
}