<?php
/**
 * Created by PhpStorm.
 * User: Evaris
 * Date: 15/06/2016
 * Time: 01:25
 */

namespace Foris\MoMoSdk;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;


/**
 * PHP Orange Money Sdk Client
 *
 * @author Fomekong Evaris @foris-master
 * GitHub: https://github.com/Foris-master/orange-money-sdk
 */
class Api
{
    /**
     * Orange Money  API Base url
     */
    const BASE_SANDBOX_URL = "https://sandbox.momodeveloper.mtn.com";
    const BASE_URL = "https://sandbox.momodeveloper.mtn.com";
    /**
     * The Query to run against the FileSystem
     * @var String;
     */
    private $service;
    /**
     * The Query to run against the FileSystem
     * @var Client;
     */
    private $client;
    /**
     * @var string or null
     */
    private $token;
    /**
     * @var string or null
     */
    private $callback_url;
    /**
     * @var string or null
     */
    private $x_reference_id;
    /**
     * @var string or null
     */
    private $primary_key;


    /**
     * Constructor
     * @param string $userid
     * @param string $password
     */
    public function __construct($service = null)
    {
        $this->service = $service;
        $this->primary_key = getenv("MOMO_" . strtoupper($this->service) . "_PRIMARY_KEY");
        $this->callback_url = getenv("MOMO_CALLBACK_URL");


        $env = getenv('SANDBOX');
        $this->is_sandbox = !(isset($env) && in_array($env, array(true, 'true', 1)));
        if ($this->is_sandbox) {
            $this->api_user = $this->gen_uuid();
            $this->x_reference_id = $this->api_user;
            $this->client = new Client(array(
                'base_uri' => self::BASE_SANDBOX_URL,
                'headers' => array(
                    'Ocp-Apim-Subscription-Key' => $this->primary_key,
                    'X-Reference-Id' => $this->x_reference_id,
                    'X-Target-Environment' => 'sandbox',
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                )
            ));
            $this->setApiKeys();

        } else {
            $this->api_user = getenv("MOMO_API_USER");
            $this->api_key = getenv("MOMO_APP_KEY");
            $this->client = new Client(array(
                'base_uri' => self::BASE_URL,
                'headers' => array(
                    'Ocp-Apim-Subscription-Key' => $this->primary_key,
                    'X-Reference-Id' => $this->x_reference_id,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                )
            ));
        }

    }

    function gen_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function setApiKeys()
    {
        $rep = $this->createApiUser();
        if ($rep instanceof Response) {
            if ($rep->getStatusCode() == "201") {
                $rep = $this->createApiKey();
                if ($rep->getStatusCode() == "201") {
                    $rep = json_decode((string)$rep->getBody(), true);
                    $this->api_key = $rep["apiKey"];
                }

            }
        }

    }

    public function createApiUser()
    {
        $body = array(
            'providerCallbackHost' => $this->callback_url
        );
        $option = array(
            'headers' => array(
                'X-Reference-Id' => $this->x_reference_id
            ),
            'json' => $body
        );
        return $this->post('v1_0/apiuser', $option);
    }

    /**
     * Call POST request
     * @param string $endpoint
     * @param string $options
     */
    private function post($endpoint, $options = null)
    {
        return $this->apiCall("post", $endpoint, $options);
    }

    /**
     * Create API query and execute a GET/POST request
     * @param string $httpMethod GET/POST
     * @param string $endpoint
     * @param string $options
     */
    private function apiCall($httpMethod, $endpoint, $options)
    {

        $options = is_array($options) ? $options : array();
        if ($this->token) {
//            for php 7.4 only
            /*$ot=array(
                'headers'=>array(
                    'Authorization' => 'Bearer ' . $this->token,
                )
            );
            $options = array_merge($ot,$options);*/


            if (isset($options['headers'])) {
                if (!isset($options['headers']['Authorization']))
                    $options['headers']['Authorization'] = 'Bearer ' . $this->token;
            } else {
                $options['headers'] = array(
                    'Authorization' => 'Bearer ' . $this->token,
                );
            }
        }

        // POST method or GET method
        try {
            if (strtolower($httpMethod) === "post") {

                /** @var Response $response */
                $response = $this->client->request('post', $endpoint, $options);

            } else {
                $response = $this->client->get($endpoint, $options);

            }
            return $response;
        } catch (GuzzleException $e) {
            return $e->getMessage();
        } catch (Exception $exception) {
            return $exception->getMessage();
        }

    }

    private function createApiKey()
    {
        return $this->post('v1_0/apiuser/' . $this->x_reference_id . '/apikey');
    }

    public function requestToPay($data)
    {
        $b = $this->prepare($data);

        $options = array(
            'headers' => array(
                'X-Reference-Id' => $b["externalId"],
            ),
            'json' => $b
        );

        return $this->post($this->service . '/v1_0/requesttopay', $options);
    }

    public function transfer($data)
    {
        $b = $this->prepare($data);

        $options = array(
            'headers' => array(
                'X-Reference-Id' => $b["externalId"],
            ),
            'json' => $b
        );

        return $this->post($this->service . '/v1_0/transfer', $options);
    }

    public function prepare($body)
    {

        $id = "MOMO_SDK_0" . rand(100000, 900000) . "_00" . rand(10000, 90000);
        $b = array(
            "externalId" => $id,
            "currency" => "EUR",
            "amount" => 0,
            "payee" => array(
                "partyIdType" => "MSISDN",
                "partyId" => "string"
            ),
            "payerMessage" => "veuillez confirmer le retrait",
            "payeeNote" => "veuillez confirmer le retrait",
        );
        $b = array_merge($b, $body);

        /* var_dump($b);
         die();*/
        return $b;
    }

    public function getTransaction($id)
    {
        $t = $this->service == 'collection' ? 'requesttopay' : 'transfer';
        return $this->get($this->service . '/v1_0/' . $t . '/' . $id);
    }

    /**
     * Call GET request
     * @param string $endpoint
     * @param string $options
     */
    private function get($endpoint, $options = null)
    {
        return $this->apiCall("get", $endpoint, $options);
    }

    /**
     * Get Token
     */
    public function getToken()
    {

        $options = array(
            'headers' => array(
                'Authorization' => 'Basic ' . base64_encode($this->api_user . ':' . $this->api_key),
            )
        );

        return $this->post($this->service . '/token/', $options);
    }

    /**
     * Set Token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getBalance()
    {

        return $this->get($this->service . '/v1_0/account/balance');
    }

    public function isAccountValid($tel)
    {
        return $this->get($this->service . '/v1_0/accountholder/msisdn/' . $tel . '/active');
    }


}
