<?php

namespace Audiens\DoubleclickClient\entity;

class ReportConfig
{
    /** @var string */
    protected $clientCustomerId;

    /** @var string */
    protected $developerToken;

    /** @var string */
    protected $userAgent;

    /** @var string */
    protected $dateMin;

    /** @var \DateTime */
    protected $dateMax;

    public function __construct($clientCustomerId, $developerToken, $userAgent, \DateTime $dateMin, \DateTime $dateMax)
    {
        $this->clientCustomerId = $clientCustomerId;
        $this->developerToken   = $developerToken;
        $this->userAgent        = $userAgent;
        $this->dateMin          = $dateMin;
        $this->dateMax          = $dateMax;
    }

    /**
     * @return string
     */
    public function getClientCustomerId()
    {
        return $this->clientCustomerId;
    }

    /**
     * @return string
     */
    public function getDeveloperToken()
    {
        return $this->developerToken;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return \DateTime
     */
    public function getDateMin()
    {
        return $this->dateMin;
    }

    /**
     * @return \DateTime
     */
    public function getDateMax()
    {
        return $this->dateMax;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return
            [
                'clientCustomerId' => $this->clientCustomerId,
                'developerToken' => $this->developerToken,
                'userAgent' => $this->userAgent,
                'dateMin' => $this->dateMin,
                'dateMax' => $this->dateMax,
            ];
    }
}
