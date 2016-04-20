<?php

namespace Audiens\DoubleclickClient\authentication;

use Audiens\DoubleclickClient\entity\BearerToken;
use Audiens\DoubleclickClient\exceptions\AuthException;

/**
 * Class AuthStrategyInterface
 */
interface AuthStrategyInterface
{

    /**
     * @param bool|false $cache
     *
     * @throws AuthException
     * @return BearerToken
     */
    public function authenticate($cache = true);

    /**
     * @return string
     */
    public function getSlug();
}
