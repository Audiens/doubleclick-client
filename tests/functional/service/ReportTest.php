<?php

namespace Test\functional\service;

use Audiens\DoubleclickClient\entity\SegmentCommunication;
use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Test\FunctionalTestCase;

class ReportTest extends FunctionalTestCase
{

    /**
     * @test
     */
    public function get_revenue_will_return_an_array()
    {
        $report = $this->buildReport();

        $reportArrayResult = $report->getRevenueReport($this->getRevenueReportConfig(new \DateTime('-10 days')));

        $this->assertNotEmpty($reportArrayResult);

        foreach ($reportArrayResult as $reportResult) {
            $this->assertInstanceOf(SegmentRevenue::class, $reportResult);
        }
    }

    /**
     * @test
     */
    public function get_dmp_report_will_return_an_array()
    {
        $report = $this->buildReport();

        $reportArrayResult = $report->getDmpReport($this->getRevenueReportConfig());

        $this->assertNotEmpty($reportArrayResult);

        foreach ($reportArrayResult as $reportResult) {
            $this->assertInstanceOf(SegmentCommunication::class, $reportResult);
        }
    }

}
