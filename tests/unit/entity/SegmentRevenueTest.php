<?php

namespace Test\unit\entity;

use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Test\TestCase;

class SegmentRevenueTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_a_value_object_but_holds_a_custom_hydration_strategy()
    {
        $segmentRevenue = SegmentRevenue::fromArray(
            [
                'userlistid' => 'segment_id',
                'clientcustomername' => 'client_name',
                'status' => 'segment_status',
                'userlistname' => 'segment_name',
                'clientproduct' => 'disregarded',
                'stats' => [
                    'clientimpressions' => 'segment_impressions',
                    'costusd' => [
                        'microamount' => 1000000,
                    ],
                ],
            ]

        );

        $this->assertEquals('segment_id', $segmentRevenue->getSegmentId());
        $this->assertEquals('client_name', $segmentRevenue->getClientName());
        $this->assertEquals('segment_status', $segmentRevenue->getSegmentStatus());
        $this->assertEquals('segment_impressions', $segmentRevenue->getSegmentImpression());
        $this->assertEquals(1, $segmentRevenue->getSegmentRevenue());
        $this->assertEquals('segment_name', $segmentRevenue->getSegmentName());
    }
}
