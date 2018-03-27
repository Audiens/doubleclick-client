<?php

namespace Test\unit\service;

use Audiens\DoubleclickClient\entity\SegmentCommunication;
use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Audiens\DoubleclickClient\service\Report;
use Audiens\DoubleclickClient\service\TwigCompiler;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Prophecy\Argument;
use Test\TestCase;

class ReportTest extends TestCase
{
    /**
     * @test
     */
    public function getRevenueReport_will_make_a_post_request_to_the_correct_endpoint()
    {
        $client = $this->prophesize(Client::class);

        $compiler       = $this->prophesize(TwigCompiler::class);
        $twigEnviroment = $this->prophesize(\Twig_Environment::class);

        $twigEnviroment->render(Argument::cetera())->shouldBeCalled();
        $client->request(Argument::cetera())->willReturn($this->getRevenueReport())->shouldBeCalled();

        $compiler->getTwig()->willReturn($twigEnviroment->reveal());

        $reportConfig = $this->getRevenueReportConfig();

        $report = new Report($client->reveal(), $compiler->reveal());

        $revenues = $report->getRevenueReport($reportConfig);

        foreach ($revenues as $revenue) {
            $this->assertInstanceOf(SegmentRevenue::class, $revenue);
        }
    }

    /**
     * @test
     */
    public function getDmpReport_will_make_a_post_request_to_the_correct_endpoint()
    {
        $client = $this->prophesize(Client::class);

        $compiler       = $this->prophesize(TwigCompiler::class);
        $twigEnviroment = $this->prophesize(\Twig_Environment::class);

        $twigEnviroment->render(Argument::cetera())->shouldBeCalled();
        $client->request(Argument::cetera())->willReturn($this->getDmpReport())->shouldBeCalled();

        $compiler->getTwig()->willReturn($twigEnviroment->reveal());

        $reportConfig = $this->getRevenueReportConfig();

        $report = new Report($client->reveal(), $compiler->reveal());

        $dmpReports = $report->getDmpReport($reportConfig);

        foreach ($dmpReports as $revenue) {
            $this->assertInstanceOf(SegmentCommunication::class, $revenue);
        }
    }

    /**
     * @test
     */
    public function getReport_will_return_a_valid_revenue_report()
    {
        $responseFake = file_get_contents(__DIR__.'/../../samples/'.self::VERSION.'/Report/getRevenueReport/ok.xml');
        $dummyStream  = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($responseFake);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());

        $webClient = $this->prophesize(ClientInterface::class);

        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());

        $report            = new Report($webClient->reveal(), new TwigCompiler(), null);
        $reportArrayResult = $report->getRevenueReport($this->getRevenueReportConfig());

        $revenue = $reportArrayResult[0];

        $this->assertEquals($revenue->getClientName(), 'Bid Manager Partner XXX');
        $this->assertEquals($revenue->getSegmentImpression(), '3150');
        $this->assertEquals($revenue->getSegmentId(), '78593479');
        $this->assertEquals($revenue->getSegmentName(), 'XXX');
    }

    /**
     * @test
     */
    public function getDmp_will_return_a_valid_dmp_report()
    {
        $responseFake = file_get_contents(__DIR__.'/../../samples/'.self::VERSION.'/Report/getDmpReport/ok.xml');
        $dummyStream  = $this->prophesize(Stream::class);
        $dummyStream->getContents()->willReturn($responseFake);
        $dummyStream->rewind()->shouldBeCalled();

        $dummyResponse = $this->prophesize(Response::class);
        $dummyResponse->getBody()->willReturn($dummyStream->reveal());

        $webClient = $this->prophesize(ClientInterface::class);

        $webClient->request(Argument::cetera())->willReturn($dummyResponse->reveal());

        $report = new Report($webClient->reveal(), new TwigCompiler(), null, getenv('CUSTOMER_ID'));

        $reportArrayResult = $report->getDmpReport($this->getRevenueReportConfig());

        /** @var SegmentCommunication $dmpReport */
        $dmpReport = $reportArrayResult[0];

        $this->assertEquals($dmpReport->getSegmentName(), 'XXX');
        $this->assertEquals($dmpReport->getSegmentId(), '520500469');
        $this->assertEquals($dmpReport->getSegmentStatus(), 'OPEN');
        $this->assertEquals($dmpReport->getSize(), '34000000');
    }

}
