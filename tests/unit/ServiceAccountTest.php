<?php

namespace Test\unit;

use Audiens\DoubleclickClient\entity\ServiceAccount;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class ServiceAccountTest
 */
class ServiceAccountTest extends TestCase
{

    /**
     * @test
     */
    public function it_is_a_value_object()
    {

        $serviceAccount = new  ServiceAccount(
            'a_private_key',
            'a_client_email',
            'a_subject'
        );

        $this->assertEquals('a_private_key', $serviceAccount->getPrivateKey());
        $this->assertEquals('a_client_email', $serviceAccount->getClientEmail());
        $this->assertContains('a_subject', $serviceAccount->getSubject());

    }


}
