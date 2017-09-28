<?php

namespace Audiens\DoubleclickClient\authentication;

use Audiens\DoubleclickClient\CachableTrait;
use Audiens\DoubleclickClient\CacheableInterface;
use Audiens\DoubleclickClient\entity\BearerToken;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\ClientInterface;

/**
 * Class GoogleOauth2DdpStrategy
 */
class Oauth2ServiceAccountStrategy implements AuthStrategyInterface, CacheableInterface
{

    use CachableTrait;

    const NAME = 'oauth2_service_account';

    const BASE_URL = 'https://www.googleapis.com/oauth2/v4/token';

    const CACHE_NAMESPACE  = 'oauth2_service_account';
    const CACHE_EXPIRATION = 1800;

    const SCOPE = 'https://ddp.googleapis.com/api/ddp/';

    /**
 * @var Cache
*/
    protected $cache;

    /**
 * @var JwtFactoryInterface
*/
    protected $jwtFactory;

    /**
     * GoogleOauth2DdpStrategy constructor.
     *
     * @param ClientInterface     $clientInterface
     * @param Cache               $cache
     * @param JwtFactoryInterface $jwtFactory
     */
    public function __construct(ClientInterface $clientInterface, Cache $cache, JwtFactoryInterface $jwtFactory)
    {
        $this->cache = $cache;
        $this->client = $clientInterface;
        $this->jwtFactory = $jwtFactory;

        $this->cacheEnabled = $cache instanceof Cache;
    }

    /**
     * @param bool|true $cache
     *
     * @return BearerToken
     */
    public function authenticate($cache = true)
    {

        $cacheKey = self::CACHE_NAMESPACE.sha1($this->jwtFactory->getHash().self::BASE_URL);

        if ($cache) {
            if ($this->cache->contains($cacheKey)) {
                return $this->cache->fetch($cacheKey);
            }
        }

        $token = $this->jwtFactory->build();

        $body = 'grant_type='.urlencode('urn:ietf:params:oauth:grant-type:jwt-bearer').'&assertion='.$token;

        $response = $this->client->request(
            'POST',
            self::BASE_URL,
            [
                'body' => $body,
                'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
            ]
        );

        $bearerToken = BearerToken::fromArray(json_decode($response->getBody()->getContents(), true));

        $response->getBody()->rewind();

        if ($this->isCacheEnabled()) {
            $this->cache->save($cacheKey, $bearerToken, self::CACHE_EXPIRATION);
        }

        return $bearerToken;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return self::NAME;
    }
}
