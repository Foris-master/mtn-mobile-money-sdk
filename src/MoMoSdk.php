<?php
/**
 * Created by PhpStorm.
 * User: evari
 * Date: 4/24/2018
 * Time: 10:59 AM
 */

namespace Foris\MoMoSdk;


use GuzzleHttp\Psr7\Response;

abstract class MoMoSdk
{

    private $api;
    /**
     * @var string or null
     */
    private $token;


    protected function formatResponse($response, $code = "200")
    {
        if (is_object($response) && $response instanceof Response) {
            $data = json_decode((string)$response->getBody(), true);
            return array("success" => $response->getStatusCode() == $code, "body" => $data);
        } elseif (is_string($response)) {
            return array("success" => false, "body" => $response);
        } else {
            return array("success" => false, "body" => $response);

        }
    }


}