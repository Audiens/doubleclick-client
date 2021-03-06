<?php

namespace Audiens\DoubleclickClient\service;

use Audiens\DoubleclickClient\ApiConfigurationInterface;
use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\CachableTrait;
use Audiens\DoubleclickClient\CacheableInterface;
use Audiens\DoubleclickClient\entity\Segment;
use Audiens\DoubleclickClient\entity\ApiResponse;
use Audiens\DoubleclickClient\exceptions\ClientException;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class UserList implements CacheableInterface, ApiConfigurationInterface
{
    use CachableTrait;

    public const BASE_URL_USER     = 'https://ddp.googleapis.com/api/ddp/provider/'.self::API_VERSION.'/UserListService?wsdl';
    public const USER_LIST_TPL     = 'userList.xml.twig';
    public const GET_USER_LIST_TPL = 'getUserList.xml.twig';

    /**
     * @var Client|Auth
     */
    protected $client;

    /**
     * @var  int
     */
    protected $memberId;

    /**
     * @var  Cache
     */
    protected $cache;

    /**
     * @var  TwigCompiler
     */
    protected $twigCompiler;

    /**
     * @var  string
     */
    protected $clientCustomerId;

    /**
     * Report constructor.
     *
     * @param ClientInterface $client
     * @param TwigCompiler    $twigCompiler
     * @param Cache|null      $cache
     * @param                 $clientCustomerId
     */
    public function __construct(ClientInterface $client, TwigCompiler $twigCompiler, Cache $cache = null, $clientCustomerId)
    {
        $this->client           = $client;
        $this->cache            = $cache;
        $this->twigCompiler     = $twigCompiler;
        $this->cacheEnabled     = $cache instanceof Cache;
        $this->clientCustomerId = $clientCustomerId;
    }

    public function createUserList(Segment $segment, $updateIfExist = false): Segment
    {
        $operator = 'ADD';

        if ($updateIfExist) {
            $operator = 'SET';
        }

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION.'/'.self::USER_LIST_TPL,
            [
                'id' => $segment->getSegmentId(),
                'name' => $segment->getSegmentName(),
                'status' => $segment->getSegmentStatus(),
                'description' => $segment->getDescription(),
                'integrationCode' => $segment->getIntegrationCode(),
                'accountUserListStatus' => $segment->getAccountUserListStatus(),
                'membershipLifeSpan' => $segment->getMembershipLifeSpan(),
                'accessReason' => $segment->getAccessReason(),
                'isEligibleForSearch' => $segment->getisEligibleForSearch(),
                'clientCustomerId' => $this->clientCustomerId,
                'operator' => $operator,
            ]
        );

        try {
            $response = $this->client->request('POST', self::BASE_URL_USER, ['body' => $requestBody]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $apiResponse = ApiResponse::fromResponse($response);

        if (!$apiResponse->isSuccessful()) {
            throw ClientException::failed($apiResponse);
        }

        if (!isset($apiResponse->getResponseArray()['body']['envelope']['body']['mutateresponse']['rval']['value'])) {
            throw ClientException::failed($apiResponse);
        }

        return Segment::fromArray($apiResponse->getResponseArray()['body']['envelope']['body']['mutateresponse']['rval']['value']);
    }

    /**
     * @param null|string $id
     *
     * @return array|Segment
     * @throws ClientException
     */
    public function getUserList($id = null)
    {
        $compiledUrl = self::BASE_URL_USER;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION.'/'.self::GET_USER_LIST_TPL,
            [
                'clientCustomerId' => $this->clientCustomerId,
                'id' => $id,
            ]
        );

        try {
            $response = $this->client->request('POST', $compiledUrl, ['body' => $requestBody]);
        } catch (RequestException $e) {
            $response = $e->getResponse();
        }

        $repositoryResponse = ApiResponse::fromResponse($response);

        if (!$repositoryResponse->isSuccessful()) {
            throw ClientException::failed($repositoryResponse);
        }

        if (!isset($repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'])
        ) {
            throw ClientException::failed($repositoryResponse);
        }

        $entries = $repositoryResponse->getResponseArray()['body']['envelope']['body']['getresponse']['rval']['entries'];

        if (is_array($entries) && isset($entries['id'])) {
            //ok, this is the case when you search a specific user list. So we don't have an array of array in response but just a single array

            return Segment::fromArray($entries);
        }

        $segments = [];

        foreach ($entries as $entry) {
            $segments[] = Segment::fromArray($entry);
        }

        return $segments;
    }
}
