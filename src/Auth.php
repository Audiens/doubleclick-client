<?php

namespace Audiens\DoubleclickClient;

use Audiens\DoubleclickClient\authentication\AuthStrategyInterface;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class Auth
 */
class Auth extends Client implements ClientInterface
{

    /**
 * @var  Cache
*/
    protected $cache;

    /**
 * @var  Client
*/
    protected $client;

    /**
 * @var string
*/
    protected $token;

    /**
 * @var AuthStrategyInterface
*/
    protected $authStrategy;

    /**
     * Auth constructor.
     *
     * @param ClientInterface       $clientInterface
     * @param AuthStrategyInterface $authStrategy
     */
    public function __construct(ClientInterface $clientInterface, AuthStrategyInterface $authStrategy)
    {
        $this->client = $clientInterface;
        $this->authStrategy = $authStrategy;

        parent::__construct([]);
    }

    /**
     * @param string $method
     * @param null   $uri
     * @param array  $options
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \Exception
     */
    public function request($method, $uri = null, array $options = [])
    {

        $optionForToken = [
            'headers' => [
                'Authorization' => $this->authStrategy->authenticate(),
            ],
        ];

        $options = array_merge($options, $optionForToken);

        return $this->client->request($method, $uri, $options);
    }
}
