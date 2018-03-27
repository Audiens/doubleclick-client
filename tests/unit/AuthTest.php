<?php

namespace Test\unit;

use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\authentication\AuthStrategyInterface;
use Audiens\DoubleclickClient\entity\BearerToken;
use GuzzleHttp\ClientInterface;
use Prophecy\Argument;
use Test\TestCase;

class AuthTest extends TestCase
{

    /**
     * @test
     */
    public function will_append_the_auth_token_to_any_request()
    {
        $client       = $this->prophesize(ClientInterface::class);
        $authStrategy = $this->prophesize(AuthStrategyInterface::class);
        $authStrategy->authenticate()->willReturn(
            BearerToken::fromArray(
                [
                    'access_token' => 'Bearer 123',
                    'token_type' => 'Bearer',
                    'expires_in' => '?',
                ]
            )
        )->shouldBeCalled();

        $expectedOptions = [
            'headers' => [
                'Authorization' => 'Bearer 123',
            ],
        ];

        $client->request('POST', '_a_uri_', Argument::any())->shouldBeCalled();

        $auth = new Auth($client->reveal(), $authStrategy->reveal());

        $auth->request('POST', '_a_uri_', []);
    }

}
