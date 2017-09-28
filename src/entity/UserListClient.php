<?php


namespace Audiens\DoubleclickClient\entity;

use GiacomoFurlan\ObjectTransmapperValidator\Annotation\Validation\Validate;

class UserListClient
{
    use TransmapHydratable;

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_INACTIVE = 'INACTIVE';
    const STATUS_UNKNOWN = 'UNKNOWN';

    /**
     * @var string
     * @Validate(type="string", mandatory=true)
     */
    protected $userlistid;

    /**
     * @var string
     * @Validate(type="string", mandatory=false)
     */
    protected $clientcustomername;

    /**
     * @var string
     * @Validate(type="string", mandatory=true)
     */
    protected $status;

    /**
     * @var string
     * @Validate(type="string", mandatory=false)
     */
    protected $userlistname;

    /**
     * @var  UserListPricing
     * @Validate(type="Audiens\DoubleclickClient\entity\UserListPricing", mandatory=false)
     */
    protected $pricingInfo;

    /**
     * @var string
     * @see Product::*
     * @Validate(type="string", mandatory=true)
     */
    protected $clientproduct;

    /**
     * @var string
     * @Validate(type="string", mandatory=true)
     */
    protected $clientid;

    /**
     * @return string
     */
    public function getUserlistid()
    {
        return $this->userlistid;
    }

    /**
     * @param int $userlistid
     */
    public function setUserlistid($userlistid)
    {
        $this->userlistid = $userlistid;
    }

    /**
     * @return string
     */
    public function getClientcustomername()
    {
        return $this->clientcustomername;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getUserlistname()
    {
        return $this->userlistname;
    }

    /**
     * @param string $userlistname
     */
    public function setUserlistname($userlistname)
    {
        $this->userlistname = $userlistname;
    }

    /**
     * @return UserListPricing
     */
    public function getPricingInfo()
    {
        return $this->pricingInfo;
    }

    /**
     * @param UserListPricing $pricingInfo
     */
    public function setPricingInfo(UserListPricing $pricingInfo)
    {
        $this->pricingInfo = $pricingInfo;
    }

    /**
     * @return string
     */
    public function getClientproduct()
    {
        return $this->clientproduct;
    }

    /**
     * @param string $clientproduct
     */
    public function setClientproduct($clientproduct)
    {
        $this->clientproduct = $clientproduct;
    }

    /**
     * @return int
     */
    public function getClientid()
    {
        return $this->clientid;
    }

    /**
     * @param string $clientid
     */
    public function setClientid($clientid)
    {
        $this->clientid = $clientid;
    }

    protected static function hydratePreprocess(array $objectArray): array
    {
        if (array_key_exists('pricingInfo', $objectArray)) {
            $objectArray['pricingInfo'] = (object)$objectArray['pricingInfo'];
        }

        $intArray = [
            'userlistid',
            'clientid'
        ];

        foreach ($intArray as $key) {
            if (is_int($objectArray[$key])) {
                $objectArray[$key] = (string)$objectArray[$key];
            }
        }

        if (isset($objectArray['clientcustomername']) && is_array($objectArray['clientcustomername'])) {
            $objectArray['clientcustomername'] = implode(',', $objectArray['clientcustomername']);
        }

        return $objectArray;
    }
}
