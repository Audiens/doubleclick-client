<?php

namespace Audiens\DoubleclickClient\entity;

/**
 * Class Error
 */
class Error
{

    use HydratableTrait;

    /**
 * @var  string 
*/
    protected $faultcode;

    /**
 * @var  string 
*/
    protected $faultstring;

    /**
     * @return string
     */
    public function getFaultcode()
    {
        return $this->faultcode;
    }

    /**
     * @return string
     */
    public function getFaultstring()
    {
        return $this->faultstring;
    }

    public function __toString()
    {
        return $this->faultcode.': '.$this->faultstring;
    }
}
