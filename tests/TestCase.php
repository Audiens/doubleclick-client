<?php

namespace Test;

use Audiens\DoubleclickClient\entity\ReportConfig;
use Doctrine\Common\Annotations\AnnotationRegistry;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Stream;

class TestCase extends \PHPUnit_Framework_TestCase
{

    public const VERSION = 'v201802';

    protected function setUp()
    {
        parent::setUp();

        $loader = include __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';
        AnnotationRegistry::registerLoader([$loader, 'loadClass']);
    }

    public function getGenericErrorResponse(): Response
    {
        $fakeResponse = $this->prophesize(Response::class);
        $stream       = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn(file_get_contents(__DIR__.'/samples/internal_error.xml'));
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse->reveal();
    }

    public function getRevenueReport($version = self::VERSION)
    {
        $fakeResponse = $this->prophesize(Response::class);
        $stream       = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn(file_get_contents(__DIR__.'/samples/'.$version.'/Report/getRevenueReport/ok.xml'));
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse->reveal();
    }

    public function getDmpReport($version = self::VERSION)
    {
        $fakeResponse = $this->prophesize(Response::class);
        $stream       = $this->prophesize(Stream::class);
        $stream->getContents()->willReturn(file_get_contents(__DIR__.'/samples/'.$version.'/Report/getDmpReport/ok.xml'));
        $stream->rewind()->willReturn(null)->shouldBeCalled();
        $fakeResponse->getBody()->willReturn($stream->reveal());

        return $fakeResponse->reveal();
    }

    public function getBearerTokenResponse(): Response
    {
        $fakeResponse = $this->prophesize(Response::class);
        $stream       = $this->prophesize(Stream::class);
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
        $stream       = $this->prophesize(Stream::class);
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
    protected function getRevenueReportConfig(\DateTime $from = null, \DateTime $to = null): ReportConfig
    {
        if (!$from) {
            $from = new \DateTime();
        }

        if (!$to) {
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
