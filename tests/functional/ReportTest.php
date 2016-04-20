<?php

namespace Test\functional;

use Prophecy\Argument;
use Test\FunctionalTestCase;

/**
 * Class ReportTest
 */
class ReportTest extends FunctionalTestCase
{

    /**
     * @test
     */
    public function get_revenue_will_return_an_array()
    {

        $report = $this->buildReport();

        $reportArrayResult = $report->getRevenueReport($this->getRevenueReportConfig());

        $this->assertNotEmpty($reportArrayResult[0]);


    }

//
//    /**
//     * @test
//     */
//    public function get_dmp_report_will_return_an_array()
//    {
//
//        $report = $this->buildReport();
//
//        $reportArrayResult = $report->getDmpReport($this->getRevenueReportConfig());
//
////        $this->assertNotEmpty($reportArrayResult[0]);
//
//
//        print_r($reportArrayResult);
//        die();
//    }

}
