<?php

namespace Audiens\DoubleclickClient\exceptions;

use Audiens\DoubleclickClient\entity\ApiResponse;

/**
 * Class UserListException
 */
class UserListException extends \Exception
{

    /**
     * @param ApiResponse $repositoryResponse
     *
     * @return self
     */
    public static function failed(ApiResponse $repositoryResponse)
    {
        return new self('Failed call: '.$repositoryResponse->getError());
    }

    /**
     * @return self
     */
    public static function validation($message)
    {
        return new self($message);
    }
}
