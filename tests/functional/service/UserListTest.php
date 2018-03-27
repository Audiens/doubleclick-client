<?php

namespace Test\functional;

use Audiens\DoubleclickClient\entity\Segment;
use Test\FunctionalTestCase;

class UserListTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function createUserList_will_update_an_existing_segment()
    {
        $userList = $this->buildUserList();

        $segments = $userList->getUserList(74255119);

        $this->assertInstanceOf(Segment::class, $segments);

        $this->assertEquals('74255119', $segments->getSegmentId());

        $randName = 'ZZ_CLOSED_SEGMENT_FOR_TESTING_'.rand(0, 1099);

        $segment = new Segment(
            74255119,
            $randName,
            'ACTIVE',
            'test',
            null,
            null,
            'OWNED',
            false,
            60
        );

        $segmentUpdated = $userList->createUserList($segment, true);

        $this->assertInstanceOf(Segment::class, $segmentUpdated);

        $this->assertEquals($randName, $segmentUpdated->getSegmentName());
    }

    /**
     * @test
     */
    public function getUserList_will_return_a_valid_user_list()
    {
        $userList = $this->buildUserList();

        $segments = $userList->getUserList();

        $this->assertNotNull($segments);

        $this->assertInternalType('array', $segments);

        $this->assertGreaterThan(0, count($segments));

        foreach ($segments as $segment) {
            $this->assertInstanceOf(Segment::class, $segment);
        }
    }
}
