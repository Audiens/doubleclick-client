<?php

namespace Test\functional;

use Audiens\DoubleclickClient\authentication\JwtServiceAccountFactory;
use Audiens\DoubleclickClient\entity\ServiceAccount;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\TokenTest;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class JwtFactoryTest
 */
class JwtFactoryTest extends TestCase
{

    /**
     * @test
     */
    public function it_will_return_a_jwt()
    {

        openssl_pkey_export(openssl_pkey_new(), $privKey);

        $serviceAccount = new ServiceAccount($privKey, 'b', 'c');

        $jwtFactory = new JwtServiceAccountFactory($serviceAccount);

        $this->assertInstanceOf(Token::class, $jwtFactory->build());

    }


}
