<?php
namespace Classes\Generic;
class AbstractHelper
{
    protected $serviceCode;

    public function setServiceCode($code)
    {
        $this->serviceCode = $code;
    }

    public function getServiceCode()
    {
        return $this->serviceCode;
    }

    public function mapSettings($settings, $map){
        $result = [];
        $map = array_intersect_key($map, $settings);
        foreach($map as $k => $value) {
            $result[$value] = !empty($settings[$k]) ? $settings[$k] : '';
        }
        return $result;
    }
}