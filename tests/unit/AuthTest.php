<?php

namespace Test\unit;

use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\authentication\AuthStrategyInterface;
use GuzzleHttp\ClientInterface;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class AuthTest
 */
class AuthTest extends TestCase
{

    /**
     * @test
     */
    public function will_append_the_auth_token_to_any_request()
    {
        $client = $this->prophesize(ClientInterface::class);
        $authStrategy = $this->prophesize(AuthStrategyInterface::class);
        $authStrategy->authenticate()->willReturn('Bearer 123')->shouldBeCalled();

        $expectedOptions = [
            'headers' => [
                'Authorization' => 'Bearer 123',
            ],
        ];

        $client->request('POST', '_a_uri_', $expectedOptions)->shouldBeCalled();

        $auth = new Auth($client->reveal(), $authStrategy->reveal());

        $auth->request('POST', '_a_uri_', []);


    }


}
