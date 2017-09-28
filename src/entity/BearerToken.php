<?php

namespace Audiens\DoubleclickClient\entity;

/**
 * Class BearerToken
 */
class BearerToken
{

    use HydratableTrait;

    private function __construct()
    {
    }

    const TOKEN_PREFIX = "Bearer";

    /**
 * @var  string
*/
    protected $access_token;

    /**
 * @var  string
*/
    protected $token_type;

    /**
 * @var  string
*/
    protected $expires_in;

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->token_type;
    }

    /**
     * @return string
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return self::TOKEN_PREFIX.' '.$this->access_token;
    }
}
