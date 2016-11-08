<?php

namespace Test;

use Audiens\DoubleclickClient\entity\ReportConfig;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;
use Prophecy\Argument;

/**
 * Class SegmentRepositoryFunctionTest
 */
class TestCase extends \PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        parent::setUp();
    }

    /**
     * @return Response
     */
    public function getGenericErrorResponse()
    {
        $fakeResponse = $this->prophesize(Response::class);
        $stream = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn(file_get_contents(__DIR__.'/samples/internal_error.xml'));
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse->reveal();
    }


    /**
     * @return Response
     */
    public function getRevenueReport()
    {
        $fakeResponse = $this->prophesize(Response::class);
        $stream = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn(file_get_contents(__DIR__.'/samples/v201609/revenue_report.xml'));
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse->reveal();
    }

    /**
     * @return Response
     */
    public function getDmpReport()
    {
        $fakeResponse = $this->prophesize(Response::class);
        $stream = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn(file_get_contents(__DIR__.'/samples/v201609/dmp_report.xml'));
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse->reveal();
    }



    /**
     * @return Response
     */
    public function getBearerTokenResponse()
    {


        $fakeResponse = $this->prophesize(Response::class);
        $stream = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn(file_get_contents(__DIR__.'/samples/bearer_token.json'));
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse->reveal();
    }


    /**
     * @param $responseBody
     *
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function getFakeResponse($responseBody)
    {

        $fakeResponse = $this->prophesize(Response::class);
        $stream = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn($responseBody);
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse;

    }


    /**
     * @param null|\Datetime $from
     * @param null|\Datetime $to
     *
     * @return ReportConfig
     */
    protected function getRevenueReportConfig(\Datetime $from = null, \Datetime $to = null)
    {

        if (!$from) {
            $from = new \DateTime();
            $to = new \DateTime();
        }

        return new ReportConfig(
            getenv('CUSTOMER_ID'),
            'Audiens',
            'Audiens',
            $from,
            $to
        );


    }

}
