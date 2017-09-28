<?php

namespace Test\functional;

use Audiens\DoubleclickClient\entity\SegmentCommunication;
use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Audiens\DoubleclickClient\service\Report;
use Audiens\DoubleclickClient\service\TwigCompiler;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
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

        $this->assertInstanceOf(SegmentRevenue::class,$reportArrayResult[0]);

    }

    /**
     * @test
     */
    public function getReport_will_return_a_valid_revenue_report()
    {
        $responseFake = file_get_contents(__DIR__ . '/../samples/v201708/responseRevenue.xml');
        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($responseFake);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());


        $webClient = $this->prophesize(ClientInterface::class);


        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());

        $report = new Report($webClient->reveal(), new TwigCompiler(), null,getenv('CUSTOMER_ID'));

        $reportArrayResult = $report->getRevenueReport($this->getRevenueReportConfig());

        $revenue = $reportArrayResult[0];

        $this->assertEquals($revenue->getClientName(), 'Bid Manager Partner 388');
        $this->assertEquals($revenue->getSegmentImpression(), '54');
        $this->assertEquals($revenue->getSegmentId(), '78593479');
        $this->assertEquals($revenue->getSegmentName(), 'The Business');
    }


    /**
     * @test
     */
    public function get_dmp_report_will_return_an_array()
    {
        $report = $this->buildReport();

        $reportArrayResult = $report->getDmpReport($this->getRevenueReportConfig());

        $this->assertNotEmpty($reportArrayResult[0]);

        $this->assertInstanceOf(SegmentCommunication::class,$reportArrayResult[0]);

    }

    /**
     * @test
     */
    public function getDmp_will_return_a_valid_dmp_report()
    {
        $responseFake = file_get_contents(__DIR__ . '/../samples/v201708/responseDmp.xml');
        $dummyStream = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($responseFake);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());


        $webClient = $this->prophesize(ClientInterface::class);


        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());

        $report = new Report($webClient->reveal(), new TwigCompiler(), null,getenv('CUSTOMER_ID'));

        $reportArrayResult = $report->getDmpReport($this->getRevenueReportConfig());

        /** @var SegmentCommunication $dmpReport */
        $dmpReport = $reportArrayResult[0];

        $this->assertEquals($dmpReport->getSegmentName(), 'The News');
        $this->assertEquals($dmpReport->getSegmentId(), '430867123');
        $this->assertEquals($dmpReport->getSegmentStatus(), 'OPEN');
        $this->assertEquals($dmpReport->getSize(), '15000000');
    }

}
