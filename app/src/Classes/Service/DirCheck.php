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
    public function runCheck()
    {
        $config = $this->getConfig()->asObject();
        $serviceCode = $this->serviceCode;
        $dir_path = $config->project->doc_root.$config->service->$serviceCode->dir_path;

        if ($dir_path) {
            $output = $this->checkConnection($dir_path);
            return $this->validateResponse($output);
        } else {
            $this->failProcess();
        }
    }

    public function checkConnection($dir_path)
    {
        $output = false;
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