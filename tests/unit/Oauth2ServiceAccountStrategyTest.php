<?php

namespace Test\unit;

use Audiens\DoubleclickClient\authentication\JwtFactoryInterface;
use Audiens\DoubleclickClient\authentication\Oauth2ServiceAccountStrategy;
use Audiens\DoubleclickClient\entity\BearerToken;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\ClientInterface;
use Lcobucci\JWT\Token;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class Oauth2ServiceAccountStrategyTest
 */
class Oauth2ServiceAccountStrategyTest extends TestCase
{

    /**
     * @test
     */
    public function authenticate_will_return_a_bearer_token()
    {
        $client = $this->prophesize(ClientInterface::class);

        $fakeResponse = $this->getBearerTokenResponse();

        $client->request(Argument::any(), Argument::any(), Argument::any())->willReturn($fakeResponse);

        $token = new Token();

        $jwtFactory = $this->prophesize(JwtFactoryInterface::class);
        $jwtFactory->build()->willReturn($token);
        $jwtFactory->getHash()->willReturn('a_simple_hash');
        $cache = $this->prophesize(Cache::class);
        $cache->contains(Argument::any())->willReturn(false)->shouldBeCalled();;

        $cache->save(Argument::any(), Argument::any(), Argument::any())->shouldBeCalled();

        $authStrategy = new Oauth2ServiceAccountStrategy($client->reveal(), $cache->reveal(), $jwtFactory->reveal());

        $bearerToken = $authStrategy->authenticate(true);

        $this->assertNotNull($bearerToken);

        $this->assertInstanceOf(BearerToken::class, $bearerToken);

        $this->assertEquals(Oauth2ServiceAccountStrategy::NAME, $authStrategy->getSlug());;

    }

    /**
     * @test
     */
    public function authenticate_will_return_a_bearer_token_with_cache()
    {

        $bearerToken = BearerToken::fromArray([]);

        $client = $this->prophesize(ClientInterface::class);

        $jwtFactory = $this->prophesize(JwtFactoryInterface::class);
        $jwtFactory->getHash()->willReturn('a_simple_hash');

        $cache = $this->prophesize(Cache::class);
        $cache->contains(Argument::any())->willReturn(true);
        $cache->fetch(Argument::any())->willReturn($bearerToken);

        $authStrategy = new Oauth2ServiceAccountStrategy($client->reveal(), $cache->reveal(), $jwtFactory->reveal());

        $bearerToken = $authStrategy->authenticate(true);

        $this->assertNotNull($bearerToken);

        $this->assertInstanceOf(BearerToken::class, $bearerToken);


    }


}
