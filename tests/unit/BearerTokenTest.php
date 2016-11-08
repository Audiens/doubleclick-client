<?php

namespace Test\unit;

use Audiens\DoubleclickClient\entity\BearerToken;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class BearerTokenTest
 */
class BearerTokenTest extends TestCase
{

    /**
     * @test
     */
    public function it_is_a_value_object()
    {

        $bearerToken = BearerToken::fromArray(
            [
                'access_token' => 'an_access_token',
                'token_type' => 'a_token_type',
                'expires_in' => 'an_expires_in',
            ]
        );

        $this->assertEquals('an_access_token', $bearerToken->getAccessToken());
        $this->assertEquals('a_token_type', $bearerToken->getTokenType());
        $this->assertEquals('an_expires_in', $bearerToken->getExpiresIn());

        $this->assertContains('an_access_token', $bearerToken->__toString());

    }


}
