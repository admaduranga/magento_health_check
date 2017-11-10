<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 7/25/16
 * Time: 2:50 PM
 */

namespace Classes\Helper;
use Classes\Generic\AbstractHelper;

class DBReader extends AbstractHelper
{
    protected $config;
    protected $connection = null;
    protected $env;
    protected $parser;
    protected $conParam;

    public function __construct(
        \Classes\Generic\AbstractHelper $env
    )
    {
        $this->parser = new \Classes\Helper\XmlParser();
        $this->env = $env;
    }

    public function setConParam($conParam)
    {
        $this->conParam = $conParam;
    }

    public function getConParam()
    {
        return $this->conParam;
    }
    public function getConnection($config=null)
    {
        // Try and connect to the database
        //$this->connection = mysqli_connect($config->host,$config->username,$config->password,$config->dbname);
        if ($this->connection === null) {
            $config = $config ? $config : $this->getConParam();
            $this->connection = new \PDO("mysql:host=$config->host;dbname=$config->dbname;charset=utf8mb4", $config->username, $config->password);
            // If connection was not successful, handle the error
            if($this->connection === false) {
                // Handle error - notify administrator, log to a file, show an error screen, etc.
                return false;
            }
        }
        return $this->connection;
    }

    public function getResultAsValue($stmt, $params=[])
    {
        $stmt->execute($params);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        foreach($row as $value) {
            return $value;
        }
    }
}
