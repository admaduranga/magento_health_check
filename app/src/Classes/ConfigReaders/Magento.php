<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 7/25/16
 * Time: 2:50 PM
 */

namespace Classes\ConfigReaders;
use Classes\Generic\AbstractHelper;

class Magento extends AbstractHelper
{
    protected $config;
    protected $parser;
    protected $dbHelper;


    public function __construct(
        \Classes\Helper\Config $config
    )
    {
        $this->parser = new \Classes\Helper\XmlParser();
        $this->config = $config;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getConfigurations($serviceCode)
    {
        return (object) $this->readSettings($serviceCode);
    }

    protected function readSettings($serviceCode)
    {
        $result = [];
        try {
            $config = $this->getConfig()->asObject();
            $parser = $this->parser->load($config->project->doc_root.'/'.$config->project->local_config);
            if (!$parser->isLoaded()) {
                throw new \Exception('Invalid Configuration');
            }
            $result = $parser->getXpathValue(
                $config->service->$serviceCode->connection->path,
                (array) $config->service->$serviceCode->connection->map
            );
        } catch (\Exception $e) {
            throw new \Exception('Invalid Configuration');
        }

        return $result;
    }

    public function getDBSystemConfig($dbHelper, $path, $store)
    {
        $conn = $dbHelper->getConnection();
        $stmt = $conn->prepare("SELECT value from core_config_data where path = :path and scope_id = :store ");
        $value = $dbHelper->getResultAsValue($stmt, [':store' => $store, ':path' => $path]);
        return $value;
    }
}
