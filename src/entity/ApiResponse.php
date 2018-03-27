<?php

namespace Audiens\DoubleclickClient\entity;

use GuzzleHttp\Psr7\Response;

class ApiResponse
{
    public const STATUS_SUCCESS = 'OK';

    /** @var bool */
    protected $successful = false;

    /** @var string */
    protected $response;

    /** @var Error */
    protected $error;

    /** @var array */
    protected $responseArray;

    public function getResponse(): string
    {
        return $this->response;
    }

    public function isSuccessful(): bool
    {
        return $this->successful;
    }

    public function getError(): Error
    {
        return $this->error;
    }

    public function getResponseArray(): array
    {
        return $this->responseArray;
    }

    public static function fromResponse(Response $response): ApiResponse
    {
        $self            = new self();
        $error           = new Error();
        $responseContent = self::getResponseContent($response);

        $self->successful    = false;
        $self->response      = $responseContent;
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

    private static function getResponseContent(Response $response): string
    {
        $responseContent = $response->getBody()->getContents();
        $response->getBody()->rewind();

        return static::asciiToUTF8($responseContent);
    }

    private static function arrayFromXml($xmlString): array
    {
        $document = new \DOMDocument(); // create dom element

        libxml_use_internal_errors(true); // silence errors
        $document->loadHTML($xmlString);
        libxml_clear_errors();

        $xml = $document->saveXML($document->documentElement);
        $xml = simplexml_load_string($xml); // create xml

        return json_decode(json_encode($xml), true); // extract array
    }

    /**
     * Converts a ASCII string with UTF-8 characters in a UTF-8 string.
     * Correctly encoded UTF-8 strings will be passed-through.
     *
     * @param string $string
     *
     * @return string
     */
    public static function asciiToUTF8(string $string): string
    {
        $windows1252Chars = [
            "\xC3\x80", "\xC3\x81", "\xC3\x82", "\xC3\x83", "\xC3\x84",
            "\xC3\x85", "\xC3\x86", "\xC3\x87", "\xC3\x88", "\xC3\x89",
            "\xC3\x8A", "\xC3\x8B", "\xC3\x8C", "\xC3\x8D", "\xC3\x8E",
            "\xC3\x8F", "\xC3\x90", "\xC3\x91", "\xC3\x92", "\xC3\x93",
            "\xC3\x94", "\xC3\x95", "\xC3\x96", "\xC3\x97", "\xC3\x98",
            "\xC3\x99", "\xC3\x9A", "\xC3\x9B", "\xC3\x9C", "\xC3\x9D",
            "\xC3\x9E", "\xC3\x9F", "\xC3\xA0", "\xC3\xA1", "\xC3\xA2",
            "\xC3\xA3", "\xC3\xA4", "\xC3\xA5", "\xC3\xA6", "\xC3\xA7",
            "\xC3\xA8", "\xC3\xA9", "\xC3\xAA", "\xC3\xAB", "\xC3\xAC",
            "\xC3\xAD", "\xC3\xAE", "\xC3\xAF", "\xC3\xB0", "\xC3\xB1",
            "\xC3\xB2", "\xC3\xB3", "\xC3\xB4", "\xC3\xB5", "\xC3\xB6",
            "\xC3\xB7", "\xC3\xB8", "\xC3\xB9", "\xC3\xBA", "\xC3\xBB",
            "\xC3\xBC", "\xC3\xBD", "\xC3\xBE", "\xC3\xBF",
        ];

        foreach ($windows1252Chars as $nonUtfChars) {
            if (stripos($string, $nonUtfChars) !== false) {
                return mb_convert_encoding($string, 'Windows-1252');
            }
        }

        return $string;
    }
}
