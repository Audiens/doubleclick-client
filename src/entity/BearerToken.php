<?php

namespace Audiens\DoubleclickClient\entity;

/**
 * Class BearerToken
 */
class BearerToken
{
    use HydratableTrait;

    /** @var  string */
    protected $access_token;

    /** @var  string */
    protected $token_type;

    /** @var  string */
    protected $expires_in;

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return string
     */
    public function getTokenType()
    {
        return $this->token_type;
    }

    /**
     * @param string $token_type
     */
    public function setTokenType($token_type)
    {
        $this->token_type = $token_type;
    }

    /**
     * @return string
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * @param string $expires_in
     */
    public function setExpiresIn($expires_in)
    {
        $this->expires_in = $expires_in;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return 'Bearer '.$this->access_token;
    }
}
