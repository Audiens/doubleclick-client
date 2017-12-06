<?php

namespace Test\functional;

use Audiens\DoubleclickClient\entity\UserListClient;
use Test\FunctionalTestCase;

/**
 * Class UserListClientTest
 */
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

        $this->assertGreaterThan(0,count($licenses));

        foreach($licenses as $license)
        {
            $this->assertInstanceOf(UserListClient::class, $license);
        }
    }

    /**
     * @test
     */
    public function it_will_fetch_by_userListId_and_clientId()
    {
        $this->markTestSkipped('Please provide userListId and clientId');

        $userClientService = $this->buildUserClientList();

        $userListId = '';
        $clientId = '';

        $license = $userClientService->getUserClientList($userListId, $clientId);

        $this->assertNotEmpty($license);

        $this->assertInstanceOf(UserListClient::class, $license);

    }
}
