<?php

namespace League\Skeleton\Test;

use Foris\MoMoSdk\Disbursement;
use PHPUnit\Framework\TestCase;

class MoMoSdkDisbursementTest extends TestCase
{
    /**
     * @var Disbursement
     */
    private $momo_disbursement;

    public function setUp(): void
{
    // Only for unit test purpose
    // putenv('MOMO_DISBURSEMENT_PRIMARY_KEY=your primary key here');
    // putenv('MOMO_CALLBACK_URL=https://myawesome.callback.com');

    putenv('MOMO_DISBURSEMENT_PRIMARY_KEY=your primary key here');
    putenv('MOMO_CALLBACK_URL=https://myawesome.callback.com');
    putenv('MOMO_DISBURSEMENT_API_USER=Your appuser');
    putenv('MOMO_DISBURSEMENT_APP_KEY=Your APP_KEY');
    putenv('MOMO_CALLBACK_HOST=https://example.com');
    putenv('MOMO_ENV=mtncameroon');
    putenv('MOMO_SDK_ENV=prod');
    putenv('MOMO_CURRENCY=XAF');
    putenv('MOMO_PROD_URL=htts://azdsdd.mtn.com');


    $this->momo_disbursement = new Disbursement();
    parent::setUp();
}


    public function testGetAccessToken()
    {

        $res = $this->momo_disbursement->getAccesToken();
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("access_token", $res["body"]);
        var_dump($res["body"]);
    }

    public function testTransfer()
    {
//        $this->assertTrue(true);
        $res = $this->momo_disbursement->transfer(200, '677777777');
        $this->assertArrayHasKey("externalId", $res);
//        var_dump($res);
        $this->assertTrue($res["success"]);
        $res = $this->momo_disbursement->getTransaction($res["externalId"]);
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("body", $res);
        $this->assertTrue($res["body"]["status"] == "SUCCESSFUL");
        var_dump($res["body"]);
    }

    public function testGetBalance()
    {
        $res = $this->momo_disbursement->getBalance();
        var_dump($res);
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("availableBalance", $res["body"]);
        var_dump($res["body"]);
    }

    public function testIsAccountValid()
    {
        $res = $this->momo_disbursement->isAccountValid("677777777");
        var_dump($res);
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("result", $res["body"]);
    }


}
