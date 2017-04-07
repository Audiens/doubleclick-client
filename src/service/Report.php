<?php

namespace Audiens\DoubleclickClient\service;

use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\CachableTrait;
use Audiens\DoubleclickClient\CacheableInterface;
use Audiens\DoubleclickClient\entity\ReportConfig;
use Audiens\DoubleclickClient\entity\SegmentCommunication;
use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Audiens\DoubleclickClient\exceptions\ReportException;
use Audiens\DoubleclickClient\entity\ApiResponse;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Class Report
 */
class Report implements CacheableInterface
{

    use CachableTrait;

    const API_VERSION                  = 'v201609';

    const BASE_URL_PROVIDER = 'https://ddp.googleapis.com/api/ddp/provider/v201609/UserListClientService?wsdl';
    const BASE_URL_DDP      = 'https://ddp.googleapis.com/api/ddp/cmu/v201609/CustomerMatchUploaderService?wsdl';
    const USER_LIST_SERVICE = 'https://ddp.googleapis.com/api/ddp/provider/v201609/UserListService?wsdl';

    /** @var Client|Auth */
    protected $client;

    /** @var  int */
    protected $memberId;

    /** @var  Cache */
    protected $cache;

    /** @var string */
    protected $baseUrl;

    /** @var  string */
    protected $baseUrlDdp;

    /** @var  TwigCompiler */
    protected $twigCompiler;

    const REVENUE_REPORT_TEMPLATE_NAME = 'revenue.xml.twig';
    const DMP_REPORT_TEMPLATE_NAME     = 'dmp.xml.twig';

    /**
     * Report constructor.
     *
     * @param ClientInterface $client
     * @param TwigCompiler $twigCompiler
     * @param Cache|null $cache
     */
    public function __construct(ClientInterface $client, TwigCompiler $twigCompiler, Cache $cache = null)
    {
        $this->client       = $client;
        $this->cache        = $cache;
        $this->twigCompiler = $twigCompiler;
        $this->cacheEnabled = $cache instanceof Cache;

        $this->baseUrl    = self::BASE_URL_PROVIDER;
        $this->baseUrlDdp = self::BASE_URL_DDP;
    }

    /**
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     */
    public function setBaseUrl($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }


    /**+
     * @param ReportConfig $reportConfig
     *
     * @return SegmentRevenue[]
     * @throws ReportException
     */
    public function getRevenueReport(ReportConfig $reportConfig)
    {

        $compiledUrl = $this->baseUrl;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION . '/' . self::REVENUE_REPORT_TEMPLATE_NAME,
            $reportConfig->toArray()
        );

        try {
            $response = $this->client->request('POST', $compiledUrl, ['body' => $requestBody]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $repositoryResponse = ApiResponse::fromResponse($response);


        if (!$repositoryResponse->isSuccessful()) {
            throw ReportException::failed($repositoryResponse);
        }

        if (!isset($repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'])
        ) {
            return [];
        }

        $entries = $repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'];

        $segmentsRevenue = [];

        foreach ($entries as $entry) {
            $segmentsRevenue[] = SegmentRevenue::fromArray($entry);
        }

        return $segmentsRevenue;
    }

    /**+
     * @param ReportConfig $reportConfig
     *
     * @return array
     * @throws ReportException
     */
    public function getDmpReport(ReportConfig $reportConfig)
    {

        $compiledUrl = self::USER_LIST_SERVICE;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION . '/' . self::DMP_REPORT_TEMPLATE_NAME,
            $reportConfig->toArray()
        );

        try {
            $response = $this->client->request('POST', $compiledUrl, ['body' => $requestBody]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $repositoryResponse = ApiResponse::fromResponse($response);

        if (!$repositoryResponse->isSuccessful()) {
            throw ReportException::failed($repositoryResponse);
        }

        if (!isset($repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'])
        ) {
            throw ReportException::missingIndex('body->envelope->body->getresponse->rval->entries');
        }

        $entries = $repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'];

        $segmentCommunication = [];

        foreach ($entries as $entry) {
            $segmentCommunication[] = SegmentCommunication::fromArray($entry);
        }

        return $segmentCommunication;
    }
}
