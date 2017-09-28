<?php

namespace Audiens\DoubleclickClient\entity;

use Audiens\DoubleclickClient\exceptions\ReportException;

/**
 * Class SegmentRevenue
 */
class SegmentCommunication extends Segment
{

    use HydratableTrait;

    /**
     * @var string
    */
    protected $size;

    /**
     * SegmentCommunication constructor.
     *
     * @param $segmentId
     * @param $segmentName
     * @param $segmentStatus
     * @param $size
     */
    public function __construct(
        $segmentId,
        $segmentName,
        $segmentStatus,
        $size
    ) {

        $this->size = $size;

        parent::__construct(
            $segmentId,
            $segmentName,
            $segmentStatus
        );
    }

    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }


    /**
     * @param array $array
     *
     * @return static
     * @throws \Exception
     */
    public static function fromArray(array $array)
    {

        if (!isset($array['id'])) {
            throw ReportException::validation('hydration: id');
        }

        if (!isset($array['name'])) {
            throw ReportException::validation('hydration: name');
        }

        if (!isset($array['status'])) {
            throw ReportException::validation('hydration: status');
        }
        if (!isset($array['size'])) {
            throw ReportException::validation('hydration: size');
        }

        return new self(
            $array['id'],
            $array['name'],
            $array['status'],
            $array['size']
        );
    }
}
