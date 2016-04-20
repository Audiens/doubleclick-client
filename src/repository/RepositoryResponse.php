<?php

namespace Audiens\DoubleclickClient\repository;

use Audiens\DoubleclickClient\entity\Error;
use GuzzleHttp\Psr7\Response;

/**
 * Class RepositoryResponse
 */
class RepositoryResponse
{

    // OK RESPONSE {"response":{"status":"OK","count":1,"start_element":0,"num_elements":100,"id":4959394,"segment":{"id":4959394,"active":true,"description":null,"member_id":3847,"code":null,"provider":"","price":0,"short_name":"Test segment4996","expire_minutes":null,"category":null,"enable_rm_piggyback":false,"last_activity":"2016-03-23 11:21:48","max_usersync_pixels":null,"parent_segment_id":null,"querystring_mapping":null,"querystring_mapping_key_value":null},"dbg":{"instance":"41.api.prod.ams1","slave_hit":false,"db":"master","user::reads":0,"user::read_limit":100,"user::read_limit_seconds":60,"user::writes":2,"user::write_limit":60,"user::write_limit_seconds":60,"reads":0,"read_limit":1073741824,"read_limit_seconds":60,"writes":2,"write_limit":1073741824,"write_limit_seconds":60,"parent_dbg_info":{"instance":"44.bm-api.prod.nym2","slave_hit":false,"db":"master","user::reads":0,"user::read_limit":100,"user::read_limit_seconds":60,"user::writes":2,"user::write_limit":60,"user::write_limit_seconds":60,"reads":0,"read_limit":1073741824,"read_limit_seconds":60,"writes":2,"write_limit":1073741824,"write_limit_seconds":60,"time":88.721990585327,"version":"1.16.497","warnings":["Field `member_id` is not available"],"slave_lag":0,"start_microtime":1458732108.3462},"time":347.10383415222,"version":"1.16.497","warnings":[],"slave_lag":0,"start_microtime":1458732108.1427}}}
    // OK DELETE "{"response":{"status":"OK","count":1,"start_element":0,"num_elements":100,"id":"4967144","dbg":{"instance":"41.api.prod.ams1","slave_hit":true,"db":"10.2.78.139","user::reads":1,"user::read_limit":100,"user::read_limit_seconds":60,"user::writes":5,"user::write_limit":60,"user::write_limit_seconds":60,"reads":1,"read_limit":1073741824,"read_limit_seconds":60,"writes":5,"write_limit":1073741824,"write_limit_seconds":60,"parent_dbg_info":{"instance":"45.bm-api.prod.nym2","slave_hit":true,"db":"10.3.81.15",
    // KO RESPONSE {"response":{"error_id":"SYNTAX","error":"Invalid path \/segment - member is required","error_description":null,"error_code":null,"service":"segment","method":"POST","dbg":{"instance":"40.api.prod.ams1","slave_hit":false,"db":"master","user::reads":0,"user::read_limit":100,"user::read_limit_seconds":60,"user::writes":1,"user::write_limit":60,"user::write_limit_seconds":60,"reads":0,"read_limit":1073741824,"read_limit_seconds":60,"writes":1,"write_limit":1073741824,"write_limit_seconds":60,"parent_dbg_info":{"instance":"44.bm-api.prod.nym2","slave_hit":false,"db":"master","user::reads":0,"user::read_limit":100,"user::read_limit_seconds":60,"user::writes":1,"user::write_limit":60,"user::write_limit_seconds":60,"reads":0,"read_limit":1073741824,"read_limit_seconds":60,"writes":1,"write_limit":1073741824,"write_limit_seconds":60,"time":48.772096633911,"version":"1.16.497","warnings":[],"slave_lag":0,"start_microtime":1458732144.0725},"time":278.25713157654,"version":"1.16.497","warnings":[],"slave_lag":0,"start_microtime":1458732143.8902}}}
    // OK RESPONSE {"response":{"status":"OK","count":1,"start_element":0,"num_elements":100,"id":25069653,"batch_segment_upload_job":{"id":25069653,"job_id":"PkIyNufLvcuVMdZ37CqXoonp3KKpjs1459321995","member_id":3847,"last_modified":"2016-03-30 07:13:15","upload_url":"https:\/\/data-api-gslb.adnxs.net\/segment-upload\/PkIyNufLvcuVMdZ37CqXoonp3KKpjs1459321995"},"dbg":{"instance":"40.api.prod.ams1","slave_hit":false,"db":"master","user::reads":0,"user::read_limit":100,"user::read_limit_seconds":60,"user::writes":2,"user::write_limit":60,"user::write_limit_seconds":60,"reads":0,"read_limit":1073741824,"read_limit_seconds":60,"writes":2,"write_limit":1073741824,"write_limit_seconds":60,"parent_dbg_info":{"instance":"45.bm-api.prod.nym2","slave_hit":false,"db":"master","user::reads":0,"user::read_limit":100,"user::read_limit_seconds":60,"user::writes":2,"user::write_limit":60,"user::write_limit_seconds":60,"reads":0,"read_limit":1073741824,"read_limit_seconds":60,"writes":2,"write_limit":1073741824,"write_limit_seconds":60,"time":102.07200050354,"version":"1.16.516","warnings":[],"slave_lag":0,"start_microtime":1459321995.0088},"time":323.7988948822,"version":"1.16.516","warnings":[],"slave_lag":1,"start_microtime":1459321994.8377}}}

//<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
//<soap:Header>
//<ResponseHeader xmlns="https://ddp.googleapis.com/api/ddp/provider/v201603">
//<requestId>000530d1f6e303200a8149c68b049a09</requestId>
//<serviceName>UserListClientService</serviceName>
//<methodName>get</methodName>
//<operations>1</operations>
//<responseTime>175</responseTime>
//</ResponseHeader>
//</soap:Header>
//<soap:Body>
//<soap:Fault>
//<faultcode>soap:Server</faultcode>
//<faultstring>[InternalApiError.UNEXPECTED_INTERNAL_API_ERROR @ com.google.ads.api.services.common.error.InternalApiError.&lt;init&gt;(InternalApiErro]</faultstring>
//<detail>
//<ApiExceptionFault xmlns="https://ddp.googleapis.com/api/ddp/provider/v201603">
//<message>[InternalApiError.UNEXPECTED_INTERNAL_API_ERROR @ com.google.ads.api.services.common.error.InternalApiError.&lt;init&gt;(InternalApiErro]</message>
//<ApplicationException.Type>ApiException</ApplicationException.Type>
//<errors xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:type="InternalApiError">
//<fieldPath></fieldPath>
//<trigger></trigger>
//<errorString>InternalApiError.UNEXPECTED_INTERNAL_API_ERROR</errorString>
//<ApiError.Type>InternalApiError</ApiError.Type>
//<reason>UNEXPECTED_INTERNAL_API_ERROR</reason>
//</errors>
//</ApiExceptionFault>
//</detail>
//</soap:Fault>
//</soap:Body>
//</soap:Envelope>


    const STATUS_SUCCESS = 'OK';

    /** @var bool */
    protected $successful = false;

    /** @var  string */
    protected $response;

    /** @var  Error */
    protected $error;

    /** @var  array */
    protected $responseArray;

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }


    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->successful;
    }

    /**
     * @param boolean $successful
     */
    public function setSuccessful($successful)
    {
        $this->successful = $successful;
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param Error $error
     */
    public function setError(Error $error)
    {
        $this->error = $error;
    }

    /**
     * @return array
     */
    public function getResponseArray()
    {
        return $this->responseArray;
    }

    /**
     * @param array $responseArray
     */
    public function setResponseArray(array $responseArray)
    {
        $this->responseArray = $responseArray;
    }

    /**
     * @param Response $response
     *
     * @return RepositoryResponse
     */
    public static function fromResponse(Response $response)
    {
        $self = new self();
        $error = new Error();
        $responseContent = self::getResponseContent($response);

        $self->successful = false;
        $self->response = $responseContent;
        $self->responseArray = self::arrayFromXml($responseContent);

        if (!isset($self->responseArray['body']['envelope']['body']['fault'])) {
            $self->setSuccessful(true);
        }

        if (!$self->isSuccessful()) {
            $error = Error::fromArray($self->responseArray['body']['envelope']['body']['fault']);
        }

        $self->setError($error);

        return $self;

    }

    /**
     * @param Response $response
     *
     * @return string
     */
    private static function getResponseContent(Response $response)
    {
        $responseContent = $response->getBody()->getContents();
        $response->getBody()->rewind();

        return $responseContent;

    }

    /**
     * @param $xmlString
     *
     * @return array
     */
    private static function arrayFromXml($xmlString)
    {

        $document = new \DOMDocument(); // create dom element

        libxml_use_internal_errors(true); // silence errors
        $document->loadHTML($xmlString);
        libxml_clear_errors();

        $xml = $document->saveXML($document->documentElement);
        $xml = simplexml_load_string($xml); // create xml

        return json_decode(json_encode($xml), true); // extract array

    }
}
