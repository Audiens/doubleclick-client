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

    const SALE_TYPE_DIRECT = 'DIRECT';
    const SALE_TYPE_SALE_FOR_RESALE = 'SALE_FOR_RESALE';

    const APPROVAL_STATE_UNAPPROVED = 'UNAPPROVED';
    const APPROVAL_STATE_APPROVED   = 'APPROVED';
    const APPROVAL_STATE_REJECTED   = 'REJECTED';

    /**
     * @var  string Readonly
     * @Validate(type="string", mandatory=true)
     */
    protected $startDate;

    /**
     * @var string
     * @Validate(type="string", mandatory=true)
     */
    protected $endDate;

    /**
     * @var  string IS0-4217
     * @Validate(type="string", regex="#^[a-zA-Z]{3}$#", mandatory=true)
     */
    protected $currencyCodeString;

    /**
     * @var int
     * @see COST_TYPE_*
     * @Validate(type="int", mandatory=true)
     */
    protected $userListCost;

    /**
     * @var string Readonly
     * @Validate(type="string", mandatory=true)
     */
    protected $creationTime;

    /**
     * @var string
     * @Validate(type="string", mandatory=true)
     */
    protected $costType;

    /**
     * @var string
     * @see SALE_TYPE_*
     * @Validate(type="string", mandatory=true)
     */
    protected $saleType;

    /**
     * @var bool
     * @Validate(type="bool", mandatory=true)
     */
    protected $isPricingActive;

    /**
     * @var string
     * @see APPROVAL_STATE_*
     * @Validate(type="string", mandatory=true)
     */
    protected $approvalState;

    /**
     * @var string
     * @Validate(type="string", mandatory=false)
     */
    protected $rejectionReason;

    /**
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return string
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @return string
     */
    public function getCurrencyCodeString()
    {
        return $this->currencyCodeString;
    }

    /**
     * @return int
     */
    public function getUserListCost()
    {
        return $this->userListCost;
    }

    /**
     * @return string
     */
    public function getCreationTime()
    {
        return $this->creationTime;
    }

    /**
     * @return string
     */
    public function getCostType()
    {
        return $this->costType;
    }

    /**
     * @return string
     */
    public function getSaleType()
    {
        return $this->saleType;
    }

    /**
     * @return bool
     */
    public function isPricingActive()
    {
        return $this->isPricingActive;
    }

    /**
     * @return string
     */
    public function getApprovalState()
    {
        return $this->approvalState;
    }

    /**
     * @return string
     */
    public function getRejectionReason()
    {
        return $this->rejectionReason;
    }

    /**
     * @param string $startDate
     */
    public function setStartDate(string $startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @param string $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    /**
     * @param string $currencyCodeString
     */
    public function setCurrencyCodeString($currencyCodeString)
    {
        $this->currencyCodeString = $currencyCodeString;
    }

    /**
     * @param int $userListCost
     */
    public function setUserListCost($userListCost)
    {
        $this->userListCost = $userListCost;
    }

    /**
     * @param string $creationTime
     */
    public function setCreationTime($creationTime)
    {
        $this->creationTime = $creationTime;
    }

    /**
     * @param string $costType
     */
    public function setCostType($costType)
    {
        $this->costType = $costType;
    }

    /**
     * @param string $saleType
     */
    public function setSaleType($saleType)
    {
        $this->saleType = $saleType;
    }

    /**
     * @param bool $isPricingActive
     */
    public function setIsPricingActive($isPricingActive)
    {
        $this->isPricingActive = $isPricingActive;
    }

    /**
     * @param string $approvalState
     */
    public function setApprovalState($approvalState)
    {
        $this->approvalState = $approvalState;
    }

    /**
     * @param string $rejectionReason
     */
    public function setRejectionReason($rejectionReason)
    {
        $this->rejectionReason = $rejectionReason;
    }
}
