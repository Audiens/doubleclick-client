<?php

namespace Audiens\DoubleclickClient\entity;

class BearerToken
{
    public const TOKEN_PREFIX = 'Bearer';

    use HydratableTrait;

    /** @var string @required */
    protected $access_token;

    /** @var string @required */
    protected $token_type;

    /** @var string @required */
    protected $expires_in;

    public function getAccessToken()
    {
        return $this->access_token;
    }

    public function getTokenType()
    {
        return $this->token_type;
    }

    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    public function __toString()
    {
        return self::TOKEN_PREFIX.' '.$this->access_token;
    }
}
