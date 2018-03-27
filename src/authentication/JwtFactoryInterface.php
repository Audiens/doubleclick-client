<?php

namespace Audiens\DoubleclickClient\authentication;

use Lcobucci\JWT\Token;

interface JwtFactoryInterface
{
    public function build(): Token;

    public function getHash(): string;
}
