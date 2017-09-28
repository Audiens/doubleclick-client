<?php

namespace Test\functional;


use Audiens\DoubleclickClient\entity\Segment;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Audiens\DoubleclickClient\service\UserList;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Prophecy\Argument;
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
        $fakeResponseContent = "<soap:Envelope xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\"><soap:Header><ResponseHeader xmlns=\"https://ddp.googleapis.com/api/ddp/provider/v201609\"><requestId>0005528a121cefa00a8131c40109745b</requestId><serviceName>UserListService</serviceName><methodName>mutate</methodName><operations>1</operations><responseTime>126</responseTime></ResponseHeader></soap:Header><soap:Body><mutateResponse xmlns=\"https://ddp.googleapis.com/api/ddp/provider/v201609\"><rval><ListReturnValue.Type>UserListReturnValue</ListReturnValue.Type><value xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:type=\"BasicUserList\"><id>482908340</id><isReadOnly>false</isReadOnly><name>716</name><description>test</description><status>OPEN</status><integrationCode></integrationCode><accessReason>OWNED</accessReason><accountUserListStatus>ACTIVE</accountUserListStatus><membershipLifeSpan>30</membershipLifeSpan><listType>REMARKETING</listType><isEligibleForSearch>true</isEligibleForSearch><isEligibleForDisplay>true</isEligibleForDisplay><UserList.Type>BasicUserList</UserList.Type></value></rval></mutateResponse></soap:Body></soap:Envelope>";


        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($fakeResponseContent);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());


        $webClient = $this->prophesize(ClientInterface::class);


        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());
        $userList = new UserList($webClient->reveal(), new TwigCompiler(), null,getenv('CUSTOMER_ID'));

        $segment = new Segment(
            482908340,
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
    public function createUserList_will_update_an_existing_segment()
    {
        $userList = $this->buildUserList();

        $segments = $userList->getUserList(74255119);

        $this->assertInstanceOf(Segment::class, $segments);

        $this->assertEquals('74255119', $segments->getSegmentId());

        $randName = rand(0,1099);
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

        $this->assertGreaterThan(0,count($segments));

        foreach($segments as $segment)
        {
            $this->assertInstanceOf(Segment::class, $segment);
        }
    }

    /**
     * @test
     */
    public function getUserList_will_return_an_array_of_segments()
    {
        $responseFake = file_get_contents(__DIR__ . '/../samples/v201708/responseUserList.xml');
        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($responseFake);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());


        $webClient = $this->prophesize(ClientInterface::class);


        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());
        $userList = new UserList($webClient->reveal(), new TwigCompiler(), null,getenv('CUSTOMER_ID'));

        $segment = $userList->getUserList(12345);

        $this->assertEquals($segment->getSegmentId(), '74188159');
        $this->assertEquals($segment->getSegmentName(), 'test');
        $this->assertEquals($segment->getSegmentStatus(), 'OPEN');
        $this->assertEquals($segment->getDescription(), 'test female');
        $this->assertEquals($segment->getIntegrationCode(), 'test.gender.f');
        $this->assertEquals($segment->getAccountUserListStatus(), 'ACTIVE');
        $this->assertEquals($segment->getAccessReason(), 'OWNED');
        $this->assertEquals($segment->getisEligibleForSearch(), 'true');
        $this->assertEquals($segment->getMembershipLifeSpan(), '90');
        $this->assertEquals($segment->getListType(), 'REMARKETING');
        $this->assertEquals($segment->getSize(), '920000');

    }
}
