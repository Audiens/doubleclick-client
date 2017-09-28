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
     */
    public function it_will_hydrate()
    {
        $array = [
            'userlistid' => 123,
            'clientcustomername' => 'test',
            'status' => 'ACTIVE',
            'userlistname' => 'testString',
            'pricingInfo' => [
                'startDate' => '11/12/2011',
                'endDate' => '09/11/2011',
                'currencyCodeString' => 'EUR',
                'userListCost' => 123,
                'creationTime' => '08/11/2011',
                'costType' => 'CPM',
                'saleType' => 'DIRECT',
                'isPricingActive' => true,
                'approvalState' => 'APPROVED',
                'rejectionReason' => 'rejected',
            ],
            'clientproduct' => 'GOOGLE_RESELLER',
            'clientid' => 789
        ];

        $mappedObject = UserListClient::fromArray($array);

        self::assertEquals($mappedObject->getUserlistid(), 123);
        self::assertEquals($mappedObject->getPricingInfo()->getCurrencyCodeString(), 'EUR');

    }
}