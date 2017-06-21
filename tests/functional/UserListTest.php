<?php

namespace Test\functional;


use Audiens\DoubleclickClient\entity\Segment;
use Test\FunctionalTestCase;

/**
 * Class UserListTest
 */
class UserListTest extends FunctionalTestCase
{

    /**
     * @test
     */
    public function it_will_create_a_new_userList()
    {
        $userList = $this->buildUserList();

        $segment = new Segment(
            rand(99,1099),
            rand(0,1099),
            'ACTIVE',
            'test',
            null,
            null,
            'OWNED',
            false,
            60
        );

        $segment = $userList->createUserList($segment);

        $this->assertNotEmpty($segment);
        $this->assertInstanceOf(Segment::class, $segment);
    }

    /**
     * @test
     */
    public function getUserList_will_return_an_array_of_segments()
    {
        $userList = $this->buildUserList();

        $segments = $userList->getUserList();

        $this->assertNotNull($segments);
        $this->assertInternalType('array', $segments);

        foreach($segments as $segment)
        {
            $this->assertInstanceOf(Segment::class, $segment);
        }
    }

    /**
     * @test
     */
    public function getUserList_will_return_a_segment_specified_by_id()
    {
        $userList = $this->buildUserList();

        $segments = $userList->getUserList(74188159);

        $this->assertInstanceOf(Segment::class, $segments);

        $this->assertEquals('74188159', $segments->getSegmentId());

    }
}
