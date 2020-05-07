<?php

namespace League\Skeleton\Test;

use Foris\MoMoSdk\Collection;

class CollectionCollectionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Collection
     */
    private $momo_collection;

    public function setUp()
    {
        //only for unit test purpose
        putenv('MOMO_COLLECTION_PRIMARY_KEY=your subcription primary key here');
        putenv('MOMO_CALLBACK_URL=https://myawesome.callback.com');

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
