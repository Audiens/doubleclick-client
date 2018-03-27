<?php

namespace Test\functional;

use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Test\FunctionalTestCase;

class RevenueReportTest extends FunctionalTestCase
{

    /**
     * @test
     */
    public function get_revenue_will_return_an_array()
    {
        $report = $this->buildReport();

        $reportArrayResult = $report->getRevenueReport($this->getRevenueReportConfig(new \DateTime('-10 days')));

        $this->assertNotEmpty($reportArrayResult[0]);

        $this->assertInstanceOf(SegmentRevenue::class, $reportArrayResult[0]);
    }

}
