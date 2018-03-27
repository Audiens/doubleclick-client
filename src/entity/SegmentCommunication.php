<?php

namespace Audiens\DoubleclickClient\entity;

use Audiens\DoubleclickClient\exceptions\ReportException;

class SegmentCommunication extends Segment
{
    use HydratableTrait;

    public function __construct($segmentId, $segmentName, $segmentStatus, $size)
    {
        $this->size = $size;

        parent::__construct($segmentId, $segmentName, $segmentStatus);
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
