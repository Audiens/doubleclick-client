<?php

namespace Test\functional\service;

use Audiens\DoubleclickClient\entity\UserListClient;
use Audiens\DoubleclickClient\entity\UserListPricing;
use PHPUnit\Framework\TestCase;
use Test\FunctionalTestCase;

class UserListClientTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function getUserList_will_return_a_valid_user_list()
    {
        $userClientList = $this->buildUserClientList();

        $licenses = $userClientList->getUserClientList();

        TestCase::assertNotNull($licenses);

        TestCase::assertIsArray($licenses);
        TestCase::assertGreaterThan(0, \count($licenses));

        $atLeastOnePricing = false;

        foreach ($licenses as $license) {
            TestCase::assertInstanceOf(UserListClient::class, $license);

            if ($license->getPricingInfo() instanceof UserListPricing) {
                $atLeastOnePricing = true;
            }
        }

        TestCase::assertTrue($atLeastOnePricing, 'there should be at least one UserListPricing');
    }

}
