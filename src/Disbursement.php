<?php
/**
 * Created by PhpStorm.
 * User: evari
 * Date: 4/24/2018
 * Time: 10:59 AM
 */

namespace Foris\MoMoSdk;


class Disbursement extends MoMoSdk
{

    private $api;
    /**
     * @var string or null
     */
    private $token;

    public function __construct(array $config = array())
    {
        $this->api = new Api("disbursement");
        if (!isset($config["implicit_token"]) || $config["implicit_token"])
            $this->getAccesToken();
    }


    public function getAccesToken()
    {

        $rep = $this->api->getToken();
        $rep = $this->formatResponse($rep);
        if ($rep["success"]) {
            $this->token = $rep["body"]["access_token"];
            $this->api->setToken($this->token);
        }
        return $rep;

    }


    public function transfer($amount, $tel, $options = array())
    {
        $id = $this->api->gen_uuid();
        $data = array(
            'amount' => $amount,
            "externalId" => $id,
            'payee' => array(
                'partyId' => $tel,
                "partyIdType" => "MSISDN",
            )
        );
        if (is_array($options))
            $data = array_merge($data, $options);

        $rep = $this->api->transfer($data);
        $rep = $this->formatResponse($rep, "202");
        return array_merge($rep, array("externalId" => $id));
    }

    public function getTransaction($id)
    {
        $rep = $this->api->getTransaction($id);
        return $this->formatResponse($rep);
    }

    public function getBalance()
    {
        $rep = $this->api->getBalance();
        return $this->formatResponse($rep);
    }

    public function isAccountValid($tel)
    {
        $rep = $this->api->isAccountValid($tel);
        return $this->formatResponse($rep);
    }


}