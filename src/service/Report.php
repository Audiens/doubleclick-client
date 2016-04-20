<?php

namespace Audiens\DoubleclickClient\service;

use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\CachableTrait;
use Audiens\DoubleclickClient\CacheableInterface;
use Audiens\DoubleclickClient\entity\ReportStatus;
use Audiens\DoubleclickClient\entity\ReportTicket;
use Audiens\DoubleclickClient\entity\ReportConfig;
use Audiens\DoubleclickClient\entity\SegmentRevenue;
use Audiens\DoubleclickClient\exceptions\ReportException;
use Audiens\DoubleclickClient\repository\RepositoryResponse;
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

    const BASE_URL_PROVIDER = 'https://ddp.googleapis.com/api/ddp/provider/v201603/UserListClientService?wsdl';
    const BASE_URL_DDP      = 'https://ddp.googleapis.com/api/ddp/cmu/v201603/CustomerMatchUploaderService?wsdl';

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
     * @param TwigCompiler    $twigCompiler
     * @param Cache|null      $cache
     */
    public function __construct(ClientInterface $client, TwigCompiler $twigCompiler, Cache $cache = null)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->twigCompiler = $twigCompiler;
        $this->cacheEnabled = $cache instanceof Cache;

        $this->baseUrl = self::BASE_URL_PROVIDER;
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
     * @param ReportConfig $revenueReportConfig
     *
     * @return SegmentRevenue[]
     * @throws ReportException
     */
    public function getRevenueReport(ReportConfig $revenueReportConfig)
    {

        $compiledUrl = $this->baseUrl;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::REVENUE_REPORT_TEMPLATE_NAME,
            $revenueReportConfig->toArray()
        );

        try {
            $response = $this->client->request('POST', $compiledUrl, ['body' => $requestBody]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $repositoryResponse = RepositoryResponse::fromResponse($response);

        if (!$repositoryResponse->isSuccessful()) {
            throw ReportException::failed($repositoryResponse);
        }

        if (!isset($repositoryResponse->getResponseArray(
            )['body']['envelope']['body']['getresponse']['rval']['entries'])
        ) {
            return [];
        }

        $entries = $repositoryResponse->getResponseArray(
        )['body']['envelope']['body']['getresponse']['rval']['entries'];

        $segmentsRevenue = [];

        foreach ($entries as $entry) {
            $segmentsRevenue[] = SegmentRevenue::fromArray($entry);
        }

        return $segmentsRevenue;

    }

    /**+
     * @param ReportConfig $revenueReportConfig
     *
     * @return \Audiens\DoubleclickClient\entity\HydratableTrait
     * @throws ReportException
     */
    public function getDmpReport(ReportConfig $revenueReportConfig)
    {

        $compiledUrl = $this->baseUrlDdp;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::DMP_REPORT_TEMPLATE_NAME,
            $revenueReportConfig->toArray()
        );

        try {
            $response = $this->client->request('POST', $compiledUrl, ['body' => $requestBody]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $repositoryResponse = RepositoryResponse::fromResponse($response);

        if (!$repositoryResponse->isSuccessful()) {
            throw ReportException::failed($repositoryResponse);
        }


        if (!isset($repositoryResponse->getResponseArray(
            )['body']['envelope']['body']['getresponse']['rval']['entries'])
        ) {
            throw ReportException::missingIndex('body->envelope->body->getresponse->rval->entries');
        }

        return $repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'];

    }
}
