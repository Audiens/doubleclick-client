<?php

namespace Audiens\DoubleclickClient\entity;

/**
 * Class SegmentRevenue
 */
class SegmentRevenue extends Segment
{

    use HydratableTrait;

    /** @var string */
    protected $clientName;

    /** @var int */
    protected $segmentImpression;

    /** @var  float */
    protected $segmentRevenue;

    /**
     * SegmentRevenue constructor.
     *
     * @param $segmentId
     * @param $clientName
     * @param $segmentName
     * @param $segmentStatus
     * @param $segmentImpression
     * @param $segmentRevenue
     */
    public function __construct(
        $segmentId,
        $clientName,
        $segmentName,
        $segmentStatus,
        $segmentImpression,
        $segmentRevenue
    ) {
        $this->clientName        = $clientName;
        $this->segmentImpression = $segmentImpression;
        $this->segmentRevenue    = $segmentRevenue;

        parent::__construct($segmentId, $segmentName, $segmentStatus);
    }

    /**
     * @return mixed
     */
    public function getSegmentRevenue()
    {
        return $this->segmentRevenue;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @return string
     */
    public function getSegmentImpression()
    {
        return $this->segmentImpression;
    }

    /**
     * @param array $array
     *
     * @return SegmentRevenue
     * @throws \Exception
     */
    public static function fromArray(array $array)
    {

        if (!isset($array['userlistid'])) {
            throw new \Exception('hydration: userlistid');
        }

        if (!isset($array['clientcustomername'])) {
            throw new \Exception('hydration: clientcustomername');
        }
        if (!isset($array['userlistname'])) {
            throw new \Exception('hydration: userlistname');
        }

        if (!isset($array['status'])) {
            throw new \Exception('hydration: status');
        }

        if (!isset($array['stats']['clientimpressions'])) {
            throw new \Exception('hydration: stats->clientimpressions');
        }

        if (!isset($array['stats']['costusd']['microamount'])) {
            throw new \Exception('hydration: stats->costusd->microamount');
        }

        $clientName = $array['clientcustomername'];

        if (is_array($array['clientcustomername'])) {
            $clientName = $array['clientid'];
        }

        return new self(
            $array['userlistid'],
            $clientName,
            $array['userlistname'],
            $array['status'],
            $array['stats']['clientimpressions'],
            (round($array['stats']['costusd']['microamount'] / 1000000, 2))
        );
    }
}
