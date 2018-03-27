<?php

namespace Audiens\DoubleclickClient\entity;

class UserListPricing
{
    use HydratableTrait;

    public const COST_TYPE_CPC = 'CPC';
    public const COST_TYPE_CPM = 'CPM';

    public const SALE_TYPE_DIRECT          = 'DIRECT';
    public const SALE_TYPE_SALE_FOR_RESALE = 'SALE_FOR_RESALE';

    public const APPROVAL_STATE_UNAPPROVED = 'UNAPPROVED';
    public const APPROVAL_STATE_APPROVED   = 'APPROVED';
    public const APPROVAL_STATE_REJECTED   = 'REJECTED';

    /** @var string @required */
    protected $currencycodestring;

    /** @var string @required */
    protected $userlistcost;

    /** @var string @required */
    protected $costtype;

    /** @var string @required */
    protected $saletype;

    /** @var string @required */
    protected $ispricingactive;

    /** @var string @required */
    protected $approvalstate;

    public function getIsPricingactive(): string
    {
        return $this->ispricingactive;
    }

    public function getCurrencyCodeString(): string
    {
        return $this->currencycodestring;
    }

    public function getUserListCost(): string
    {
        return $this->userlistcost;
    }

    public function getCostType(): string
    {
        return $this->costtype;
    }

    public function getSaleType(): string
    {
        return $this->saletype;
    }

    public function isPricingActive(): string
    {
        return $this->ispricingactive;
    }

    public function getApprovalstate(): string
    {
        return $this->approvalstate;
    }

    public function setCurrencyCodeString(string $currencycodestring): void
    {
        $this->currencycodestring = $currencycodestring;
    }

    public function setUserListCost(string $userlistcost): void
    {
        $this->userlistcost = $userlistcost;
    }

    public function setCostType(string $costtype): void
    {
        $this->costtype = $costtype;
    }

    public function setSaleType(string $saletype): void
    {
        $this->saletype = $saletype;
    }

    public function setIsPricingActive(string $ispricingactive): void
    {
        $this->ispricingactive = $ispricingactive;
    }

    public function setApprovalstate(string $approvalstate): void
    {
        $this->approvalstate = $approvalstate;
    }
}
