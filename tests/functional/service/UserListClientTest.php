<?php

namespace Test\functional;

use Audiens\DoubleclickClient\entity\UserListClient;
use Audiens\DoubleclickClient\entity\UserListPricing;
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

        $this->assertNotNull($licenses);

        $this->assertInternalType('array', $licenses);
        $this->assertGreaterThan(0, \count($licenses));

        $atLeastOnePricing = false;

        foreach ($licenses as $license) {
            $this->assertInstanceOf(UserListClient::class, $license);

            if ($license->getPricingInfo() instanceof UserListPricing) {
                $atLeastOnePricing = true;
            }
        }

        $this->assertTrue($atLeastOnePricing, 'there should be at least one UserListPricing');
    }

}
