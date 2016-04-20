<?php

namespace Audiens\DoubleclickClient\entity;

/**
 * Class SegmentRevenue
 */
class SegmentRevenue
{

    use HydratableTrait;

    /** @var int */
    protected $segmentId;

    /** @var string */
    protected $clientName;

    /** @var string */
    protected $segmentName;

    /** @var string */
    protected $segmentStatus;

    /** @var string */
    protected $segmentImpression;

    protected $segmentRevenue;

    /**
     * SegmentRevenue constructor.
     *
     * @param int    $segmentId
     * @param string $clientName
     * @param string $segmentName
     * @param string $segmentStatus
     * @param string $segmentImpression
     */
    public function __construct(
        $segmentId,
        $clientName,
        $segmentName,
        $segmentStatus,
        $segmentImpression,
        $segmentRevenue
    ) {
        $this->segmentId = $segmentId;
        $this->clientName = $clientName;
        $this->segmentName = $segmentName;
        $this->segmentStatus = $segmentStatus;
        $this->segmentImpression = $segmentImpression;
        $this->segmentRevenue = $segmentRevenue;
    }

    /**
     * @return mixed
     */
    public function getSegmentRevenue()
    {
        return $this->segmentRevenue;
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
    public function getClientName()
    {
        return $this->clientName;
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

//          [userlistid] => 78610639
//          [clientcustomername] => Bid Manager Partner 353167
//          [status] => ACTIVE
//          [userlistname] => Audiens: ITALY > H3G > AGE > 45-54
//          [clientproduct] => INVITE_ADVERTISER
//          [stats] => Array
//                          (
//                              [clientimpressions] => 85896
//                              [costusd] => Array
//                                                  (
//                                                     [comparablevalue.type] => Money
//                                                     [microamount] => 77544224
//                                                   )
//                            )

        if (!isset($array['userlistid'])) {
            throw new \Exception('hydration: userlistid');
        }

        if (!isset($array['clientcustomername'])) {
            throw new \Exception('hydration: clientcustomername');
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

        return new self(
            $array['userlistid'],
            $array['clientcustomername'],
            $array['stats']['clientimpressions'],
            $array['status'],
            $array['stats']['clientimpressions'],
            (round($array['stats']['costusd']['microamount'] / 1000000, 2))
        );


    }
}
