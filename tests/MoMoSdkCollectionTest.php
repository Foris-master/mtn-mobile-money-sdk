<?php

namespace League\Skeleton\Test;

use Foris\MoMoSdk\Collection;
use PHPUnit\Framework\TestCase;


class MoMoSdkCollectionTest extends TestCase
{
    /**
     * @var Collection
     */
    private $momo_collection;

    public function setUp(): void
    {
        //only for unit test purpose
        // putenv('MOMO_COLLECTION_PRIMARY_KEY=your primary key here');
        // putenv('MOMO_CALLBACK_URL=https://myawesome.callback.com');

        putenv('MOMO_COLLECTION_PRIMARY_KEY=your primary key here');
        putenv('MOMO_CALLBACK_URL=https://myawesome.callback.com');
        putenv('MOMO_COLLECTION_API_USER=Your appuser');
        putenv('MOMO_COLLECTION_APP_KEY=Your_APP_KEY');
        putenv('MOMO_CALLBACK_HOST=azz.com');
        putenv('MOMO_ENV=mtncameroon');
        putenv('MOMO_SDK_ENV=prod');
        putenv('MOMO_CURRENCY=XAF');
        $this->momo_collection = new Collection();
        parent::setUp();
    }

    public function testGetAccessToken()
    {

        $res = $this->momo_collection->getAccesToken();
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("access_token", $res["body"]);
        var_dump($res["body"]);
    }

    public function testRequestToPay()
    {
//        $this->assertTrue(true);
        $res = $this->momo_collection->requestToPay(200, '677777777');
        $this->assertArrayHasKey("externalId", $res);
        $this->assertTrue($res["success"]);
        $res = $this->momo_collection->getTransaction($res["externalId"]);
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("body", $res);
        $this->assertTrue($res["body"]["status"] == "SUCCESSFUL");
        var_dump($res["body"]);
    }

    public function testGetBalance()
    {
        $res = $this->momo_collection->getBalance();
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("availableBalance", $res["body"]);
        var_dump($res["body"]);
    }

    public function testIsAccountValid()
    {
        $res = $this->momo_collection->isAccountValid("677777777");
        var_dump($res);
        $this->assertTrue($res["success"]);
        $this->assertArrayHasKey("result", $res["body"]);
    }


}
