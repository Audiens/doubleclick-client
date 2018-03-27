<?php

namespace Audiens\DoubleclickClient\entity;

class Error
{
    use HydratableTrait;

    /** @var  string */
    protected $faultcode;

    /** @var  string */
    protected $faultstring;

    public function getFaultcode()
    {
        return $this->faultcode;
    }

    public function getFaultstring()
    {
        return $this->faultstring;
    }

    public function __toString()
    {
        return $this->faultcode.': '.$this->faultstring;
    }
}
