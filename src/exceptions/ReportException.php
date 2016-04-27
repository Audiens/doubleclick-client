<?php

namespace Audiens\DoubleclickClient\exceptions;

use Audiens\DoubleclickClient\entity\ApiResponse;

/**
 * Class ReportException
 */
class ReportException extends \Exception
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

    /**+
     * @param $missingIndex
     *
     * @return self
     */
    public static function missingIndex($missingIndex)
    {
        return new self('Invalid reposnse missing: '.$missingIndex);
    }

    /**
     * @return self
     */
    public static function validation($message)
    {
        return new self($message);
    }
}
