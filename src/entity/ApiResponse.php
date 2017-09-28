<?php

namespace Audiens\DoubleclickClient\entity;

use GuzzleHttp\Psr7\Response;

/**
 * Class RepositoryResponse
 */
class ApiResponse
{

    private function __construct()
    {
    }

    const STATUS_SUCCESS = 'OK';

    /**
 * @var bool
*/
    protected $successful = false;

    /**
 * @var  string
*/
    protected $response;

    /**
 * @var  Error
*/
    protected $error;

    /**
 * @var  array
*/
    protected $responseArray;

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return boolean
     */
    public function isSuccessful()
    {
        return $this->successful;
    }

    /**
     * @return Error
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @return array
     */
    public function getResponseArray()
    {
        return $this->responseArray;
    }

    /**
     * @param Response $response
     *
     * @return ApiResponse
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
            $self->successful = true;
        }

        if (!$self->isSuccessful()) {
            $error = Error::fromArray($self->responseArray['body']['envelope']['body']['fault']);
        }

        $self->error = $error;

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
