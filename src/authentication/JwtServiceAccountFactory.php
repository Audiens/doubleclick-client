<?php

namespace Audiens\DoubleclickClient\authentication;

use Audiens\DoubleclickClient\entity\ServiceAccount;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Rsa\Sha256;

/**
 * Class JwtServiceAccountFactory
 */
class JwtServiceAccountFactory implements JwtFactoryInterface
{

    const SCOPE = 'https://ddp.googleapis.com/api/ddp/';

    /** @var ServiceAccount */
    protected $serviceAccount;

    /**
     * JwtFactory constructor.
     *
     * @param ServiceAccount $serviceAccount
     */
    public function __construct(ServiceAccount $serviceAccount)
    {
        $this->serviceAccount = $serviceAccount;
    }

    /**
     *
     * iss      The email address of the service account.
     * scope    A space-delimited list of the permissions that the application requests.
     * aud      A descriptor of the intended target of the assertion. When making an access token request this value is
     * sub      the user to impersonate as there should be a domain wide auth
     * always   https://www.googleapis.com/oauth2/v4/token. exp    The expiration time of the assertion, specified as
     * seconds  since 00:00:00 UTC, January 1, 1970. This value has a maximum of 1 hour after the issued time. iat
     * The time the assertion was issued, specified as seconds since 00:00:00 UTC, January 1, 1970.
     *
     * @return \Lcobucci\JWT\Token
     */
    public function build()
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

    /**
     * @return string
     */
    public function getHash()
    {

        return sha1($this->serviceAccount->getClientEmail().$this->serviceAccount->getSubject());
    }
}
