<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 7/25/16
 * Time: 2:47 PM
 */

namespace Classes\Service;

use Classes\Generic\AbstractService;
use Classes\Generic\InterfaceService;

class MySql extends AbstractService implements InterfaceService
{
    /**
     * Run the required statements to check whether the service is up and running
     * @return bool
     * @override
     * @inheritdoc
     */
    public function runCheck()
    {
        $config = $this->getConfig()->getConfigReader()->getConfigurations();
        if ($config) {
            $output = $this->checkConnection($config);
            return $this->validateResponse($output);
        } else {
            $this->failProcess();
        }
    }



    /**
     * Function that check connection
     * @param $config
     * @return string
     */
    protected function checkConnection($connection)
    {
        try {
            if (!empty($connection)) {
                $host = $connection->host;
                $user = $connection->username;
                $pass = $connection->password;
            }
            $output = shell_exec("mysql -h$host -u$user -p$pass -e\"show processlist\"");
            return $output;
        } catch (\Exception $e) {
            echo 'Cannot Connect to Mysql';
        }

    }
}