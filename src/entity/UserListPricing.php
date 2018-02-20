<?php


namespace Audiens\DoubleclickClient\entity;

use GiacomoFurlan\ObjectTransmapperValidator\Annotation\Validation\Validate;

/**
 * Class UserListPricing
 */
class UserListPricing
{
    use TransmapHydratable;

    const COST_TYPE_CPC = 'CPC';
    const COST_TYPE_CPM = 'CPM';

    const SALE_TYPE_DIRECT          = 'DIRECT';
    const SALE_TYPE_SALE_FOR_RESALE = 'SALE_FOR_RESALE';

    const APPROVAL_STATE_UNAPPROVED = 'UNAPPROVED';
    const APPROVAL_STATE_APPROVED   = 'APPROVED';
    const APPROVAL_STATE_REJECTED   = 'REJECTED';

    /**
     * @var string IS0-4217
     * @Validate(type="string", regex="#^[a-zA-Z]{3}$#", mandatory=true)
     */
    protected $currencycodestring;

    /**
     * @var string
     * @see COST_TYPE_*
     * @Validate(type="string", mandatory=true)
     */
    protected $userlistcost;

    /**
     * @var string
     * @Validate(type="string", mandatory=true)
     */
    protected $costtype;

    /**
     * @var string
     * @see SALE_TYPE_*
     * @Validate(type="string", mandatory=true)
     */
    protected $saletype;

    /**
     * @var string
     * @Validate(type="string", mandatory=true)
     */
    protected $ispricingactive;

    /**
     * @var string
     * @see APPROVAL_STATE_*
     * @Validate(type="string", mandatory=true)
     */
    protected $approvalstate;

    public function getIsPricingactive()
    {
        return $this->ispricingactive;
    }

    public function getCurrencyCodeString()
    {
        return $this->currencycodestring;
    }

    public function getUserListCost()
    {
        return $this->userlistcost;
    }

    public function getCostType()
    {
        return $this->costtype;
    }

    public function getSaleType()
    {
        return $this->saletype;
    }

    public function isPricingActive()
    {
        return $this->ispricingactive;
    }

    public function getApprovalstate()
    {
        return $this->approvalstate;
    }

    public function setCurrencyCodeString($currencycodestring)
    {
        $this->currencycodestring = $currencycodestring;
    }

    public function setUserListCost($userlistcost)
    {
        $this->userlistcost = $userlistcost;
    }

    public function setCostType($costtype)
    {
        $this->costtype = $costtype;
    }

    public function setSaleType($saletype)
    {
        $this->saletype = $saletype;
    }

    public function setIsPricingActive($ispricingactive)
    {
        $this->ispricingactive = $ispricingactive;
    }

    public function setApprovalstate($approvalstate)
    {
        $this->approvalstate = $approvalstate;
    }

}
