<?php

namespace Audiens\DoubleclickClient\entity;

use Audiens\DoubleclickClient\exceptions\ClientException;

/**
 * Class Segment
 */
class Segment
{

    /**
     * @var int
     */
    protected $segmentId;

    /**
     * @var string
     */
    protected $segmentName;

    /**
     * @var string
     */
    protected $segmentStatus;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $integrationCode;

    /**
     * @var string
     */
    protected $accountUserListStatus;

    /**
     * @var string
     */
    protected $accessReason;

    /**
     * @var boolean
     */
    protected $isEligibleForSearch;

    /**
     * @var float
     */
    protected $membershipLifeSpan;

    /**
     * @var string
     */
    protected $listType;

    /**
     * @var string
     */
    protected $size;

    /**
     * Segment constructor.
     *
     * @param int $segmentId
     * @param string $segmentName
     * @param string $segmentStatus
     * @param string $description
     * @param string $integrationCode
     * @param string $accountUserListStatus
     * @param $accessReason
     * @param $isEligibleForSearch
     * @param $membershipLifeSpan
     */
    public function __construct($segmentId, $segmentName, $segmentStatus, $description = null, $integrationCode = null, $accountUserListStatus = null, $accessReason = null, $isEligibleForSearch = null, $membershipLifeSpan = null)
    {
        $this->segmentId = $segmentId;
        $this->segmentName = $segmentName;
        $this->segmentStatus = $segmentStatus;
        $this->description = $description;
        $this->integrationCode = $integrationCode;
        $this->accountUserListStatus = $accountUserListStatus;
        $this->accessReason = $accessReason;
        $this->isEligibleForSearch = $isEligibleForSearch;
        $this->membershipLifeSpan = $membershipLifeSpan;
    }


    /**
     * @return int
     */
    public function getSegmentId()
    {
        return $this->segmentId;
    }

    /**
     * @return string
     */
    public function getSegmentName()
    {
        return $this->segmentName;
    }

    /**
     * @param $name
     */
    public function setSegmentName($name)
    {
        $this->segmentName = $name;
    }

    /**
     * @return string
     */
    public function getSegmentStatus()
    {
        return $this->segmentStatus;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getIntegrationCode()
    {
        return $this->integrationCode;
    }

    /**
     * @param string $integrationCode
     */
    public function setIntegrationCode($integrationCode)
    {
        $this->integrationCode = $integrationCode;
    }

    /**
     * @return string
     */
    public function getAccountUserListStatus()
    {
        return $this->accountUserListStatus;
    }

    /**
     * @param string $accountUserListStatus
     */
    public function setAccountUserListStatus($accountUserListStatus)
    {
        $this->accountUserListStatus = $accountUserListStatus;
    }

    /**
     * @return mixed
     */
    public function getAccessReason()
    {
        return $this->accessReason;
    }

    /**
     * @param mixed $accessReason
     */
    public function setAccessReason($accessReason)
    {
        $this->accessReason = $accessReason;
    }

    /**
     * @return mixed
     */
    public function getisEligibleForSearch()
    {
        return $this->isEligibleForSearch;
    }

    /**
     * @param mixed $isEligibleForSearch
     */
    public function setIsEligibleForSearch($isEligibleForSearch)
    {
        $this->isEligibleForSearch = $isEligibleForSearch;
    }

    /**
     * @return mixed
     */
    public function getMembershipLifeSpan()
    {
        return $this->membershipLifeSpan;
    }

    /**
     * @param mixed $membershipLifeSpan
     */
    public function setMembershipLifeSpan($membershipLifeSpan)
    {
        $this->membershipLifeSpan = $membershipLifeSpan;
    }

    /**
     * @return mixed
     */
    public function getListType()
    {
        return $this->listType;
    }

    /**
     * @param  $listType
     */
    public function setListType($listType)
    {
        $this->listType = $listType;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }


    public static function fromArray(array $array)
    {


        if (!isset($array['id'])) {
            throw ClientException::validation('hydration: id');
        }

        if (!isset($array['name'])) {
            throw ClientException::validation('hydration: name');
        }

        if (!isset($array['status'])) {
            throw ClientException::validation('hydration: status');
        }

        $segment = new self(
            $array['id'],
            $array['name'],
            $array['status']
        );


        if (isset($array['description']) && !is_array($array['description'])) {
            $segment->setDescription($array['description']);
        }


        if (isset($array['accountuserliststatus']) && !is_array($array['accountuserliststatus'])) {
            $segment->setAccountUserListStatus($array['accountuserliststatus']);
        }
        if (isset($array['accessreason']) && !is_array($array['accessreason'])) {
            $segment->setAccessReason($array['accessreason']);
        }

        if (isset($array['iseligibleforsearch']) && !is_array($array['iseligibleforsearch'])) {
            $segment->setIsEligibleForSearch($array['iseligibleforsearch']);
        }
        if (isset($array['membershiplifespan']) && !is_array($array['membershiplifespan'])) {
            $segment->setMembershipLifeSpan($array['membershiplifespan']);
        }

        if (isset($array['listtype']) && !is_array($array['listtype'])) {
            $segment->setListType($array['listtype']);
        }

        if (isset($array['size']) && !is_array($array['size'])) {
            $segment->setSize($array['size']);
        }

        if (isset($array['integrationcode']) && !is_array($array['integrationcode'])) {
            $segment->setIntegrationCode($array['integrationcode']);
        }

        return $segment;
    }
}
