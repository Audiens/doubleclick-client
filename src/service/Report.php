<?php

namespace Audiens\DoubleclickClient\service;

use Audiens\DoubleclickClient\ApiConfigurationInterface;
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

class Report implements CacheableInterface, ApiConfigurationInterface
{

    use CachableTrait;

    public const BASE_URL_PROVIDER = 'https://ddp.googleapis.com/api/ddp/provider/'.self::API_VERSION.'/UserListClientService?wsdl';
    public const BASE_URL_DDP      = 'https://ddp.googleapis.com/api/ddp/cmu/'.self::API_VERSION.'/CustomerMatchUploaderService?wsdl';
    public const USER_LIST_SERVICE = 'https://ddp.googleapis.com/api/ddp/provider/'.self::API_VERSION.'/UserListService?wsdl';

    public const REVENUE_REPORT_TEMPLATE_NAME = 'revenue.xml.twig';
    public const DMP_REPORT_TEMPLATE_NAME     = 'dmp.xml.twig';

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

    public function __construct(ClientInterface $client, TwigCompiler $twigCompiler, Cache $cache = null)
    {
        $this->client       = $client;
        $this->cache        = $cache;
        $this->twigCompiler = $twigCompiler;
        $this->cacheEnabled = $cache instanceof Cache;

        $this->baseUrl    = self::BASE_URL_PROVIDER;
        $this->baseUrlDdp = self::BASE_URL_DDP;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(string $baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function getRevenueReport(ReportConfig $reportConfig): array
    {
        $compiledUrl = $this->baseUrl;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION.'/'.self::REVENUE_REPORT_TEMPLATE_NAME,
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

        if (!isset($repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'])) {
            return [];
        }

        $entries = $repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'];

        if (\is_array($entries) && isset($entries['userlistid'])) {
            $segmentsRevenue[] = SegmentRevenue::fromArray($entries);

            return $segmentsRevenue;
        }

        $segmentsRevenue = [];

        foreach ($entries as $entry) {
            $segmentsRevenue[] = SegmentRevenue::fromArray($entry);
        }

        return $segmentsRevenue;
    }

    /**
     * @param ReportConfig $reportConfig
     *
     * @return array
     * @throws ReportException
     */
    public function getDmpReport(ReportConfig $reportConfig): array
    {
        $compiledUrl = self::USER_LIST_SERVICE;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION.'/'.self::DMP_REPORT_TEMPLATE_NAME,
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

        if (is_array($entries) && isset($entries['id'])) {
            $segmentCommunication[] = SegmentCommunication::fromArray($entries);

            return $segmentCommunication;
        }
        foreach ($entries as $entry) {
            $segmentCommunication[] = SegmentCommunication::fromArray($entry);
        }

        return $segmentCommunication;
    }
}
