<?php

namespace Audiens\DoubleclickClient\exceptions;

/**
 * Class AuthException
 */
class AuthException extends \Exception
{

    const DEFAULT_MESSAGE = "Something wrong with the autentication: ";

    /**
     * @param $reason
     *
     * @return self
     */
    public static function authFailed($reason)
    {
        return new self(self::DEFAULT_MESSAGE.$reason, 0, null);
    }
}
