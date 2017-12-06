<?php

namespace Test\unit;

use Audiens\DoubleclickClient\entity\Product;
use Audiens\DoubleclickClient\entity\UserListClient;
use Audiens\DoubleclickClient\entity\UserListPricing;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Audiens\DoubleclickClient\service\UserListClientService;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use SimpleXMLElement;
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

    /**
     * @test
     */
    public function getUserClientList_will_pass_the_right_query_to_the_client()
    {
        $data = [
            'userListId' => '7a451bf0-d9a8-46ef-9708-e113e6a95a66',
            'clientId' => '4748f5b0-3375-4e11-ace4-87744faf9462',
            'clientCustomerId' => 'f911c9f4-e19f-455c-8a15-f6c37d6a3e22',
        ];

        $that = $this;

        /** @var Client|ObjectProphecy $client */
        $client = $this->prophesize(Client::class);
        $client
            ->request('POST', UserListClientService::URL_LIST_CLIENT, Argument::type('array'))
            ->will(function ($arguments) use ($that, $data) {
                $body = $arguments[2]['body'] ?? null;
                $that->assertNotNull($body);

                $xml = new SimpleXMLElement($body);

                $clientCustomerId = $xml->Header->RequestHeader->clientCustomerId ?? null;
                $that->assertNotNull($clientCustomerId);
                $that->assertEquals($data['clientCustomerId'], $clientCustomerId);

                $serviceSelector = $xml->Body->get->serviceSelector ?? null;
                $that->assertNotNull($serviceSelector);
                $predicates = ((array)$serviceSelector)['predicates'];
                $that->assertNotNull($predicates);
                $that->assertCount(2, $predicates);

                foreach ($predicates as $predicate) {
                    switch ($predicate->field) {
                        case 'UserListId':
                            $that->assertEquals('EQUALS', $predicate->operator);
                            $that->assertEquals($data['userListId'], $predicate->values);
                            break;
                        case 'ClientId':
                            $that->assertEquals('EQUALS', $predicate->operator);
                            $that->assertEquals($data['clientId'], $predicate->values);
                            break;
                        default:
                            $this->assertTrue(false, 'Unknown predicate');
                            break;
                    }
                }

                $body = file_get_contents(
                    __DIR__
                    .DIRECTORY_SEPARATOR.'..'
                    .DIRECTORY_SEPARATOR.'samples'
                    .DIRECTORY_SEPARATOR.'v201708'
                    .DIRECTORY_SEPARATOR.'responseUserClientList.xml'
                );

                return new Response(200, [], $body);
            })->shouldBeCalledTimes(1);

        $service = new UserListClientService($client->reveal(), null, new TwigCompiler(), $data['clientCustomerId']);

        $service->getUserClientList($data['userListId'], $data['clientId']);
    }
}
