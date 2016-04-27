<?php

namespace Test\functional;

use Audiens\DoubleclickClient\entity\ReportConfig;
use Prophecy\Argument;
use Test\TestCase;

/**
 * Class ReportConfigTest
 */
class ReportConfigTest extends TestCase
{

    /**
     * @test
     */
    public function it_is_a_value_object()
    {

        $min = new \DateTime();
        $max = new \DateTime();

        $reportConfig = new ReportConfig(
            'clientCustomerId',
            'developerToken',
            'userAgent',
            $min,
            $max
        );

        $this->assertEquals($min, $reportConfig->getDateMin());
        $this->assertEquals($max, $reportConfig->getDateMax());
        $this->assertEquals('developerToken', $reportConfig->getDeveloperToken());
        $this->assertEquals('clientCustomerId', $reportConfig->getClientCustomerId());
        $this->assertEquals('userAgent', $reportConfig->getUserAgent());

        $asArray = $reportConfig->toArray();

        $this->assertArrayHasKey('clientCustomerId',$asArray);
        $this->assertArrayHasKey('developerToken',$asArray);
        $this->assertArrayHasKey('dateMin',$asArray);
        $this->assertArrayHasKey('dateMax',$asArray);


    }

}
