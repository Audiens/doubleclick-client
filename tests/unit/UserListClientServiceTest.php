<?php

namespace Test\unit;

use Audiens\DoubleclickClient\entity\Product;
use Audiens\DoubleclickClient\entity\UserListClient;
use Audiens\DoubleclickClient\entity\UserListPricing;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Audiens\DoubleclickClient\service\UserListClientService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class UserListClientServiceTest
 */
class UserListClientServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_will_create_a_new_userClientList()
    {
        $responseFake = file_get_contents(
            __DIR__.DIRECTORY_SEPARATOR
            .'..'.DIRECTORY_SEPARATOR
            .'samples'.DIRECTORY_SEPARATOR
            .'v201708'.DIRECTORY_SEPARATOR
            .'responseLicense.xml'
        );

        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($responseFake);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());


        $webClient = $this->prophesize(ClientInterface::class);


        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());
        $userClientListService = new UserListClientService(
            $webClient->reveal(),
            null,
            new TwigCompiler(), '123'
        );

        $userListPricing = new UserListPricing();

        $userListPricing->setUserListCost(1);
        $userListPricing->setCostType(UserListPricing::COST_TYPE_CPM);
        $userListPricing->setSaleType(UserListPricing::SALE_TYPE_DIRECT);
        $userListPricing->setCurrencyCodeString('EUR');
        $userListPricing->setApprovalState(UserListPricing::APPROVAL_STATE_APPROVED);


        $userListClient = new UserListClient();

        $userListClient->setStatus(UserListClient::STATUS_ACTIVE);
        $userListClient->setUserlistid('519128554');
        $userListClient->setClientproduct(Product::INVITE_PARTNER);
        $userListClient->setClientid('1384757');
        $userListClient->setPricingInfo($userListPricing);

        $userListClientNew = $userClientListService->createUserClientList($userListClient);

        $this->assertNotEmpty($userListClientNew);
        $this->assertInstanceOf(UserListClient::class, $userListClientNew);
    }
}
