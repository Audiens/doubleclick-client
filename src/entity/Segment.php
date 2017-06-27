<?php

namespace Audiens\DoubleclickClient\entity;

use Audiens\DoubleclickClient\exceptions\UserListException;

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
            throw UserListException::validation('hydration: id');
        }

        if (!isset($array['name'])) {
            throw UserListException::validation('hydration: name');
        }

        if (!isset($array['status'])) {
            throw UserListException::validation('hydration: status');
        }

        if (!isset($array['description'])) {
            throw UserListException::validation('hydration: description');
        }


        if (!isset($array['accountuserliststatus'])) {
            throw UserListException::validation('hydration: accountuserliststatus');
        }
        if (!isset($array['accessreason'])) {
            throw UserListException::validation('hydration: accessreason');
        }

        if (!isset($array['iseligibleforsearch'])) {
            throw UserListException::validation('hydration: iseligibleforsearch');
        }
        if (!isset($array['membershiplifespan'])) {
            throw UserListException::validation('hydration: membershiplifespan');
        }


        $segment = new self(
            $array['id'],
            $array['name'],
            $array['status'],
            $array['description'],
            null,
            $array['accountuserliststatus'],
            $array['accessreason'],
            $array['iseligibleforsearch'],
            $array['membershiplifespan']
        );


        if (isset($array['listtype'])) {
            $segment->setListType($array['listtype']);
        }

        if (isset($array['size'])) {
            $segment->setSize($array['size']);
        }

        if (isset($array['integrationcode'])) {
            $segment->setIntegrationCode($array['integrationcode']);
        }

        return $segment;


    }


}
