<?php

namespace Test\unit;

use Audiens\DoubleclickClient\entity\SegmentCommunication;
use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Audiens\DoubleclickClient\service\Report;
use Audiens\DoubleclickClient\service\TwigCompiler;
use Prophecy\Argument;
use GuzzleHttp\Client;
use Test\TestCase;

/**
 * Class ReportTest
 */
class ReportTest extends TestCase
{

    /**
     * @test
     */
    public function getRevenueReport_will_make_a_post_request_to_the_correct_endpoint()
    {

        $client   = $this->prophesize(Client::class);

        $compiler = $this->prophesize(TwigCompiler::class);
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

        $client   = $this->prophesize(Client::class);

        $compiler = $this->prophesize(TwigCompiler::class);
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



}
