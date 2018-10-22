<?php

namespace Framework\Http;


interface ResponseInterface
{
    public function getbody();

    /**
     * @param $body
     * @return static
     */
    public function withBody($body);

    public function getStatusCode();

    public function getReasonPhrase();

    /**
     * @param $code
     * @param string $reasonPhrase
     * @return static
     */
    public function withStatus($code, $reasonPhrase = '');

    public function getHeaders(): array;

    public function hasHeader($header): bool;

    public function getHeader($header);

    /**
     * @param $header
     * @param $value
     * @return static
     */
    public function withHeader($header, $value);
}