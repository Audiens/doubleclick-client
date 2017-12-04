<?php


namespace Audiens\DoubleclickClient\service;

use Audiens\DoubleclickClient\Auth;
use Audiens\DoubleclickClient\CachableTrait;
use Audiens\DoubleclickClient\CacheableInterface;
use Audiens\DoubleclickClient\entity\ApiResponse;
use Audiens\DoubleclickClient\exceptions\ClientException;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\Client;

use Audiens\DoubleclickClient\entity\UserListClient;
use GuzzleHttp\Exception\RequestException;

/**
 * Class UserListClientService
 */
class UserListClientService implements CacheableInterface
{
    use CachableTrait;

    const API_VERSION = 'v201708';

    const URL_LIST_CLIENT = 'https://ddp.googleapis.com/api/ddp/provider/v201708/UserListClientService?wsdl';
    const USER_LIST_CLIENT_TPL = 'userListClient.xml.twig';
    const GET_USER_CLIENT_LIST_TPL = 'getUserClientList.xml.twig';

    /**
     * @var Client|Auth
     */
    protected $client;

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
     * UserListClient constructor.
     * @param Auth|Client $client
     * @param Cache $cache
     * @param TwigCompiler $twigCompiler
     * @param string $clientCustomerId
     */
    public function __construct($client, Cache $cache = null, TwigCompiler $twigCompiler, $clientCustomerId)
    {
        $this->client = $client;
        $this->cache = $cache;
        $this->twigCompiler = $twigCompiler;
        $this->clientCustomerId = $clientCustomerId;
    }

    /**
     * @param UserListClient $client
     * @param bool $updateIfExist
     * @return UserListClient
     * @throws ClientException
     */
    public function createUserClientList(UserListClient $client, $updateIfExist = false)
    {
        $operator = 'ADD';

        if ($updateIfExist) {
            $operator = 'SET';
        }

        $context = [
            'status' => $client->getStatus(),
            'userlistid' => $client->getUserlistid(),
            'operator' => $operator,
            'clientCustomerId' => $this->clientCustomerId,
            'clientid' => $client->getClientid(),
        ];


        if ($client->getPricingInfo()) {
            $context['pricingInfo'] = $client->getPricingInfo();
        }

        if ($client->getClientproduct()) {
            $context['clientproduct'] = $client->getClientproduct();
        }

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION . '/' . self::USER_LIST_CLIENT_TPL,
            $context
        );


        try {
            $response = $this->client->request('POST', self::URL_LIST_CLIENT, ['body' => $requestBody]);
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

        return UserListClient::fromArray($apiResponse->getResponseArray()['body']['envelope']['body']['mutateresponse']['rval']['value']);
    }


    /**
     * @param null $userListId
     * @param null $clientId
     * @return UserListClient[]|UserListClient
     * @throws ClientException
     */
    public function getUserClientList($userListId = null, $clientId = null)
    {
        $compiledUrl = self::URL_LIST_CLIENT;

        $requestBody = $this->twigCompiler->getTwig()->render(
            self::API_VERSION . '/' . self::GET_USER_CLIENT_LIST_TPL,
            [
                'clientCustomerId' => $this->clientCustomerId,
                'userlistid' => $userListId,
                'clientId' => $clientId
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

        if (is_array($entries) && isset($entries['userlistid'])) {
            return UserListClient::fromArray($entries);
        }

        $licenses = [];

        foreach ($entries as $entry) {
            $licenses[] = UserListClient::fromArray($entry);
        }

        return $licenses;
    }
}
