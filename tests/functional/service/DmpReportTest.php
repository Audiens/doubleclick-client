<?php

namespace Test\functional\service;

use Audiens\DoubleclickClient\entity\SegmentCommunication;
use Test\FunctionalTestCase;

class DmpReportTest extends FunctionalTestCase
{

    /**
     * @test
     */
    public function get_dmp_report_will_return_an_array()
    {
        $report = $this->buildReport();

        $reportArrayResult = $report->getDmpReport($this->getRevenueReportConfig());

        $this->assertNotEmpty($reportArrayResult[0]);

        $this->assertInstanceOf(SegmentCommunication::class, $reportArrayResult[0]);
    }

}
