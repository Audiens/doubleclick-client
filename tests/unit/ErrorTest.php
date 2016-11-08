<?php

namespace Test\unit;

use Audiens\DoubleclickClient\entity\Error;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class ErrorTest
 */
class ErrorTest extends TestCase
{

    /**
     * @test
     */
    public function it_is_a_value_object()
    {

        $error = Error::fromArray(
            [
                'faultcode' => 'a_fault_code',
                'faultstring' => 'a_faultstring',
            ]
        );

        $this->assertEquals('a_fault_code', $error->getFaultcode());
        $this->assertEquals('a_faultstring', $error->getFaultstring());

        $this->assertContains('a_fault_code', $error->__toString());
        $this->assertContains('a_faultstring', $error->__toString());

    }


}
