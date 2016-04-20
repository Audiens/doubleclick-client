<?php

namespace Audiens\DoubleclickClient\entity;

/**
 * Class ServiceAccount
 */
class ServiceAccount
{

    /** @var  string */
    protected $privateKey;

    /** @var  string */
    protected $clientEmail;

    /** @var  string */
    protected $subject;

    /**
     * ServiceAccount constructor.
     *
     * @param string $privateKey
     * @param string $clientEmail
     * @param string $subject
     */
    public function __construct($privateKey, $clientEmail, $subject)
    {
        $this->privateKey = $privateKey;
        $this->clientEmail = $clientEmail;
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @return string
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }
}
