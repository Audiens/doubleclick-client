<?php

namespace Audiens\DoubleclickClient\entity;

/**
 * Class Segment
 */
class Segment
{

    /** @var int */
    protected $segmentId;

    /** @var string */
    protected $segmentName;

    /** @var string */
    protected $segmentStatus;

    /**
     * Segment constructor.
     *
     * @param $segmentId
     * @param $segmentName
     * @param $segmentStatus
     */
    public function __construct(
        $segmentId,
        $segmentName,
        $segmentStatus
    ) {
        $this->segmentId = $segmentId;
        $this->segmentName = $segmentName;
        $this->segmentStatus = $segmentStatus;
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
}
