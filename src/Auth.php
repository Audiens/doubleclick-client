<?php

namespace Audiens\DoubleclickClient;

use Audiens\DoubleclickClient\authentication\AuthStrategyInterface;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\RequestInterface;

/**
 * Class Auth
 */
class Auth implements ClientInterface
{

    /** @var  Cache */
    protected $cache;

    /** @var  Client */
    protected $client;

    /** @var string */
    protected $token;

    /** @var AuthStrategyInterface */
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

        try {
            return $this->client->request($method, $uri, $options);
        } catch (RequestException $e) {
            $responseBody = $e->getResponse()->getBody()->getContents();
            $e->getResponse()->getBody()->rewind();

            if (!$this->needToRevalidate($responseBody)) {
                throw $e;
            }

            $optionForToken = [
                'headers' => [
                    'Authorization' => $this->authStrategy->authenticate(false),
                ],
            ];

            $options = array_merge($options, $optionForToken);

            return $this->client->request($method, $uri, $options);
        }

    }

    /**
     * @inheritDoc
     */
    public function send(RequestInterface $request, array $options = [])
    {
        return $this->client->send($request, $options);
    }

    /**
     * @inheritDoc
     */
    public function sendAsync(RequestInterface $request, array $options = [])
    {
        return $this->client->sendAsync($request, $options);
    }

    /**
     * @inheritDoc
     */
    public function requestAsync($method, $uri, array $options = [])
    {
        return $this->client->requestAsync($method, $uri, $options);
    }

    /**
     * @inheritDoc
     */
    public function getConfig($option = null)
    {
        return $this->client->getConfig($option);
    }

    /**
     * @param $xmlstring
     *
     * @return array
     */
    protected function needToRevalidate($xmlstring)
    {

        print_r($xmlstring);
        die();
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($xmlstring);
        libxml_clear_errors();
        $xml = $doc->saveXML($doc->documentElement);
        $xml = simplexml_load_string($xml);

        return false;


    }
}
