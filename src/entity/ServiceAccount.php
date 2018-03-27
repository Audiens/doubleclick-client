<?php

namespace Audiens\DoubleclickClient\entity;

class ServiceAccount
{

    /** @var string */
    protected $privateKey;

    /** @var string */
    protected $clientEmail;

    /** @var string */
    protected $subject;

    public function __construct(string $privateKey, string $clientEmail, string $subject)
    {
        $this->privateKey  = $privateKey;
        $this->clientEmail = $clientEmail;
        $this->subject     = $subject;
    }

    public function getPrivateKey(): string
    {
        return $this->privateKey;
    }

    public function getClientEmail(): string
    {
        return $this->clientEmail;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
}
