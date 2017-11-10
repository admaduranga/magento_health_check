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

class Http extends AbstractService implements InterfaceService
{
    const CONST_HTTP_SUCCESS_CODE = 200;

    /**
     * @var string
     */
    protected $serviceCode = 'internal-http-server';

    /**
     * @var string
     */
    protected $url;

    /**
     * Http constructor.
     * @param string $url
     */
    public function __construct($url = "http://localhost")
    {
        $this->url = $url;
    }

    /**
     * @return bool
     */
    public function runCheck()
    {
        $output = $this->getCurlRef();
        return $this->validateResponse($output);
    }

    /**
     * @param $output
     * @return bool
     */
    public function validateResponse($output)
    {
        if ($output && $output == self::CONST_HTTP_SUCCESS_CODE) {
            return true;
        }
        return false;
    }

    /**
     * @return mixed
     */
    protected function getCurlRef()
    {
        $s = curl_init();
        curl_setopt($s, CURLOPT_URL, $this->url);
        curl_setopt($s, CURLOPT_RETURNTRANSFER, true);
        @curl_setopt($s, CURLOPT_HEADER, true);  // we want headers
        @curl_setopt($s, CURLOPT_NOBODY, true);  // we don't need body
        $curlOutput = curl_exec($s);
        if (!empty($curlOutput)) {
            $code = curl_getinfo($s, CURLINFO_HTTP_CODE);
        }
        return $code;
    }

    public function init()
    {
        // TODO: Implement init() method.
    }

}