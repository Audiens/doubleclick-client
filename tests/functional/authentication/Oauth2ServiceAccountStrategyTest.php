<?php

namespace Test\functional\authentication;

use Test\FunctionalTestCase;

class Oauth2ServiceAccountStrategyTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function authenticate_will_return_a_bearer_token()
    {
        $authStrategy = $this->buildOauth2ServiceAccountStrategy();

        $token = $authStrategy->authenticate();

        $this->assertNotNull($token);

        $this->assertNotEmpty($token->getAccessToken());
    }
}
