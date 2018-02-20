<?php

namespace Test\unit;

use Audiens\DoubleclickClient\entity\UserListClient;
use Test\TestCase;

/**
 * Class UserListClientTest
 */
class UserListClientTest extends TestCase
{

    /**
     * @test
     * @throws \Audiens\DoubleclickClient\exceptions\ClientException
     */
    public function it_will_hydrate()
    {
        $array = [
            'userlistid' => 123,
            'clientcustomername' => 'test',
            'status' => 'ACTIVE',
            'userlistname' => 'testString',
            'pricinginfo' => [
                'startdate' => '11/12/2011',
                'enddate' => '09/11/2011',
                'currencycodestring' => 'EUR',
                'userlistcost' => '123',
                'creationtime' => '08/11/2011',
                'costtype' => 'CPM',
                'saletype' => 'DIRECT',
                'ispricingactive' => 'true',
                'approvalstate' => 'APPROVED',
                'rejectionreason' => 'rejected',
            ],
            'clientproduct' => 'GOOGLE_RESELLER',
            'clientid' => 789
        ];

        $mappedObject = UserListClient::fromArray($array);

        self::assertEquals($mappedObject->getUserlistid(), 123);
        self::assertEquals($mappedObject->getPricingInfo()->getCurrencyCodeString(), 'EUR');

    }
}
