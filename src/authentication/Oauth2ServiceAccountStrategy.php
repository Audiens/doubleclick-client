<?php

namespace Audiens\DoubleclickClient\authentication;

use Audiens\DoubleclickClient\CachableTrait;
use Audiens\DoubleclickClient\CacheableInterface;
use Audiens\DoubleclickClient\entity\BearerToken;
use Audiens\DoubleclickClient\entity\ServiceAccount;
use Doctrine\Common\Cache\Cache;
use GuzzleHttp\ClientInterface;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Rsa\Sha256;

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

    /** @var Cache */
    protected $cache;

    /** @var ServiceAccount */
    protected $serviceAccount;

    /**
     * GoogleOauth2DdpStrategy constructor.
     *
     * @param ClientInterface $clientInterface
     * @param Cache           $cache
     * @param ServiceAccount  $serviceAccount
     */
    public function __construct(ClientInterface $clientInterface, Cache $cache, ServiceAccount $serviceAccount)
    {
        $this->cache = $cache;
        $this->client = $clientInterface;
        $this->serviceAccount = $serviceAccount;

        $this->cacheEnabled = $cache instanceof Cache;
    }

    /**
     * @param bool|true $cache
     *
     * @return BearerToken
     */
    public function authenticate($cache = true)
    {

        $cacheKey = self::CACHE_NAMESPACE.sha1($this->serviceAccount->getClientEmail().self::BASE_URL);


        if ($cache) {
            if ($this->cache->contains($cacheKey)) {
                return $this->cache->fetch($cacheKey);
            }
        }

        $token = $this->getJwt();

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

    /**
     *
     * iss    The email address of the service account.
     * scope  A space-delimited list of the permissions that the application requests.
     * aud    A descriptor of the intended target of the assertion. When making an access token request this value is
     * sub    the user to impersonate as there should be a domain wide auth
     * always https://www.googleapis.com/oauth2/v4/token. exp    The expiration time of the assertion, specified as
     * seconds since 00:00:00 UTC, January 1, 1970. This value has a maximum of 1 hour after the issued time. iat
     * The time the assertion was issued, specified as seconds since 00:00:00 UTC, January 1, 1970.
     *
     * @return \Lcobucci\JWT\Token
     */
    protected function getJwt()
    {
        return (new Builder())
            ->setIssuer($this->serviceAccount->getClientEmail())// iss claim
            ->setAudience('https://www.googleapis.com/oauth2/v4/token')// aud claim
            ->setSubject($this->serviceAccount->getSubject())// sub claim
            ->setIssuedAt(time())// iat claim
            ->setExpiration(time() + 3600)// exp claim
            ->set('scope', self::SCOPE)// custom claim
            ->sign(
                new Sha256(),
                $this->serviceAccount->getPrivateKey()
            )
            ->getToken(); // Retrieves the generated token
    }
}
