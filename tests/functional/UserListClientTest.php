<?php

namespace Test\functional;
use Audiens\DoubleclickClient\entity\Product;
use Audiens\DoubleclickClient\entity\UserListClient;
use Audiens\DoubleclickClient\entity\UserListPricing;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Audiens\DoubleclickClient\service\UserListClientService;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use GuzzleHttp\ClientInterface;
use Prophecy\Argument;
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
    public function it_will_create_a_new_userClientList()
    {
        $responseFake = file_get_contents(__DIR__ . '/../samples/v201708/responseLicense.xml');

        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($responseFake);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());


        $webClient = $this->prophesize(ClientInterface::class);


        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());
        $userClientListService = new UserListClientService($webClient->reveal(),null, new TwigCompiler(),getenv('CUSTOMER_ID'));

        $userListPricing = new UserListPricing();

        $userListPricing->setUserListCost(1);
        $userListPricing->setCostType(UserListPricing::COST_TYPE_CPM);
        $userListPricing->setSaleType(UserListPricing::SALE_TYPE_DIRECT);
        $userListPricing->setCurrencyCodeString('EUR');
        $userListPricing->setApprovalState(UserListPricing::APPROVAL_STATE_APPROVED);


        $userClientList = new UserListClient();

        $userClientList->setStatus(UserListClient::STATUS_ACTIVE);
        $userClientList->setUserlistid('519128554');
        $userClientList->setClientproduct(Product::INVITE_PARTNER);
        $userClientList->setClientid('1384757');
        $userClientList->setPricingInfo($userListPricing);

        $userClientListNew = $userClientListService->createUserClientList($userClientList);

        $this->assertNotEmpty($userClientListNew);
        $this->assertInstanceOf(UserListClient::class, $userClientListNew);
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