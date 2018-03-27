<?php

namespace Audiens\DoubleclickClient\exceptions;

use Audiens\DoubleclickClient\entity\ApiResponse;

class ClientException extends \Exception
{
    public static function failed(ApiResponse $apiResponse): ClientException
    {
        return new self('Failed call: '.$apiResponse->getError());
    }

    public static function validation($message): ClientException
    {
        return new self($message);
    }
}
