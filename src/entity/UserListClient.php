<?php

namespace Audiens\DoubleclickClient\entity;

class UserListClient
{
    use HydratableTrait;

    public const        STATUS_ACTIVE   = 'ACTIVE';
    public const        STATUS_INACTIVE = 'INACTIVE';
    public const        STATUS_UNKNOWN  = 'UNKNOWN';

    /** @var string @required */
    protected $userlistid;

    /** @var string|null */
    protected $clientcustomername;

    /** @var string @required */
    protected $status;

    /** @var string|null */
    protected $userlistname;

    /** @var UserListPricing|null */
    protected $pricingInfo;

    /** @var string @required */
    protected $clientproduct;

    /** @var string @required */
    protected $clientid;

    public function setUserlistid(string $userlistid): void
    {
        $this->userlistid = $userlistid;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setUserlistname(string $userlistname): void
    {
        $this->userlistname = $userlistname;
    }

    public function setPricingInfo(UserListPricing $pricingInfo): void
    {
        $this->pricingInfo = $pricingInfo;
    }

    public function setClientproduct(string $clientproduct): void
    {
        $this->clientproduct = $clientproduct;
    }

    public function setClientid(string $clientid): void
    {
        $this->clientid = $clientid;
    }

    public function getUserlistid(): string
    {
        return $this->userlistid;
    }

    public function getClientcustomername(): ?string
    {
        return $this->clientcustomername;
    }

    public function getUserlistname(): ?string
    {
        return $this->userlistname;
    }

    public function getPricingInfo(): ?UserListPricing
    {
        return $this->pricingInfo;
    }

    public function getClientproduct(): string
    {
        return $this->clientproduct;
    }

    public function getClientid(): ?string
    {
        return $this->clientid;
    }

    public static function preProcess(array $objectArray): array
    {
        if (isset($objectArray['clientcustomername']) && \is_array($objectArray['clientcustomername'])) {
            $objectArray['clientcustomername'] = implode(',', $objectArray['clientcustomername']) ?? '';
        }

        if (array_key_exists('pricinginfo', $objectArray)) {
            $objectArray['pricingInfo'] = UserListPricing::fromArray($objectArray['pricinginfo']);
        }

        return $objectArray;
    }
}
