<?php

namespace Audiens\DoubleclickClient\authentication;

use Audiens\DoubleclickClient\entity\BearerToken;

interface AuthStrategyInterface
{
    public function authenticate(bool $cache = true): BearerToken;

    public function getSlug(): string;
}
