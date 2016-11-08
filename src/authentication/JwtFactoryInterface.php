<?php

namespace Audiens\DoubleclickClient\authentication;

/**
 * Class JwtFactoryInterface
 */
interface JwtFactoryInterface
{

    /**
     * @return \Lcobucci\JWT\Token
     */
    public function build();

    /**
     * @return string
     */
    public function getHash();
}
