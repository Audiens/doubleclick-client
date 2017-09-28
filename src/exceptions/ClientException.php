<?php

namespace Audiens\DoubleclickClient\exceptions;

use Audiens\DoubleclickClient\entity\ApiResponse;

/**
 * Class UserListException
 */
class ClientException extends \Exception
{

    /**
     * @param ApiResponse $apiResponse
     *
     * @return self
     */
    public static function failed(ApiResponse $apiResponse)
    {
        return new self('Failed call: '.$apiResponse->getError());
    }

    /**
     * @param $message
     * @return ClientException
     */
    public static function validation($message)
    {
        return new self($message);
    }
}
