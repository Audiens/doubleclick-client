<?php

namespace Test\unit\service;

use Audiens\DoubleclickClient\entity\Segment;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Audiens\DoubleclickClient\service\UserList;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Test\TestCase;

class UserListTest extends TestCase
{

    /**
     * @test
     */
    public function createUserList_it_will_create_a_new_userList()
    {
        $fakeResponseContent = file_get_contents(__DIR__.'/../../samples/'.self::VERSION.'/UserList/createUserList/ok.xml');

        /** @var Stream|ObjectProphecy $dummyStream */
        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($fakeResponseContent);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());

        $webClient = $this->prophesize(ClientInterface::class);

        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());
        $userList = new UserList($webClient->reveal(), new TwigCompiler(), null, '123');

        $segment = new Segment(
            482908340,
            random_int(0, 1099),
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
    public function createUserList_it_will_create_a_new_userList_with_correct_name_encoding()
    {
        $name = 'xxx àèìòù';

        $fakeResponseContent = file_get_contents(__DIR__.'/../../samples/'.self::VERSION.'/UserList/createUserList/ok_with_latins.xml');

        /** @var Stream|ObjectProphecy $dummyStream */
        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($fakeResponseContent);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());

        $webClient = $this->prophesize(ClientInterface::class);

        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());
        $userList = new UserList($webClient->reveal(), new TwigCompiler(), null, '123');

        $segment = new Segment(482908340, random_int(0, 1099), 'ACTIVE', $name, null, null, 'OWNED', false, 60);

        $segment = $userList->createUserList($segment);

        $this->assertNotEmpty($segment);
        $this->assertInstanceOf(Segment::class, $segment);
        $this->assertEquals($name, $segment->getSegmentName());
    }

    /**
     * @test
     */
    public function getUserList_will_return_an_array_of_segments()
    {
        $fakeResponse = file_get_contents(__DIR__.'/../../samples/'.self::VERSION.'/UserList/getUserList/ok.xml');

        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($fakeResponse);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());

        $webClient = $this->prophesize(ClientInterface::class);

        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());
        $userList = new UserList($webClient->reveal(), new TwigCompiler(), null, '123');

        $segment = $userList->getUserList(12345);

        $this->assertEquals($segment->getSegmentId(), '74188159');
        $this->assertEquals($segment->getSegmentName(), 'test');
        $this->assertEquals($segment->getSegmentStatus(), 'OPEN');
        $this->assertEquals($segment->getDescription(), 'test female');
        $this->assertEquals($segment->getIntegrationCode(), 'xxx');
        $this->assertEquals($segment->getAccountUserListStatus(), 'ACTIVE');
        $this->assertEquals($segment->getAccessReason(), 'OWNED');
        $this->assertEquals($segment->getisEligibleForSearch(), 'true');
        $this->assertEquals($segment->getMembershipLifeSpan(), '90');
        $this->assertEquals($segment->getListType(), 'REMARKETING');
        $this->assertEquals($segment->getSize(), '920000');
    }
}
