<?php
/**
 * Created by PhpStorm.
 * User: dilhan
 * Date: 7/25/16
 * Time: 11:54 AM
 */

namespace Classes\Generic;


interface InterfaceService
{
    /**
     * Run the required statements to check whether the service is up and running
     * @return bool
     */
    public function runCheck();

    /**
     * Validate the response to determine service is up and running
     * @param $response
     * @return bool
     */
    public function validateResponse($response);
}