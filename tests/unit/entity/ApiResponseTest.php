<?php

namespace Test\unit\entity;

use Audiens\DoubleclickClient\entity\ApiResponse;
use Audiens\DoubleclickClient\entity\Error;
use Test\TestCase;

class ApiResponseTest extends TestCase
{
    /**
     * @test
     */
    public function can_parse_a_soap_response_when_there_is_an_error()
    {
        $response = $this->getGenericErrorResponse();

        $apiResponse = ApiResponse::fromResponse($response);

        $this->assertFalse($apiResponse->isSuccessful());

        $this->assertInstanceOf(Error::class, $apiResponse->getError());
        $this->assertInternalType('array', $apiResponse->getResponseArray());

        $this->assertNotEmpty($apiResponse->getResponse());
    }

    /**
     * @test
     */
    public function can_parse_a_soap_response_when_there_is_a_response()
    {
        $response    = $this->getRevenueReport();
        $apiResponse = ApiResponse::fromResponse($response);
        $this->assertTrue($apiResponse->isSuccessful());

        $response    = $this->getRevenueReport();
        $apiResponse = ApiResponse::fromResponse($response);
        $this->assertTrue($apiResponse->isSuccessful());
    }
}
