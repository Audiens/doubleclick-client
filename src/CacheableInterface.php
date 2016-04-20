<?php

namespace Audiens\DoubleclickClient;

/**
 * Class CacheableInterface
 */
interface CacheableInterface
{

    /**
     * @return boolean
     */
    public function isCacheEnabled();

    /**
     * @return void
     */
    public function disableCache();

    /**
     * @return void
     */
    public function enableCache();
}
