<?php

namespace PiSystems\Fakturownia\Api;

use Exception;
use PiSystems\Fakturownia\Curl\Curl;
use PiSystems\Fakturownia\Utilities\Logger;

abstract class ApiAction
{
    const GET = 'GET';
    const POST = 'POST';
    const DELETE = 'DELETE';
    const PUT = 'PUT';

    protected Curl $curl;

    protected string $contentType = 'application/json';

    public function __construct(
        protected readonly string $apiUrl,
        protected readonly string $tokenApi,
    )
    {
        $this->curl = new Curl();
    }

    public function getHttpResponseMessage(): string
    {
        return $this->curl->getHttpResponseMessage();
    }

    public function getHttpResponseCode(): int
    {
        return $this->curl->getHttpResponseCode();
    }

    public function getResult(): string|bool
    {
        return $this->curl->getResult();
    }

    public function getParsedRequestResult(): string|array
    {
        if ($this->getResult() === '') {
            return [];
        }

        if ($this->getResult() === 'ok') {
            return $this->getResult();
        }

        $parsedResult = json_decode($this->getResult(), true);

        if (is_null($parsedResult)) {
            throw new Exception('Error decoding response to JSON');
        }

        return $parsedResult;
    }

    public function run(
        string $requestMethod,
        string $apiMethod,
        array  $fields = [],
        array  $requestBody = [],
        array  $headers = []
    ): array
    {
        $parsedResult = $this->sendRequest($requestMethod, $apiMethod, $fields, $requestBody, $headers)->getParsedRequestResult();

        return is_array($parsedResult) ? $parsedResult : [$parsedResult];
    }

    protected function sendRequest(string $requestMethod, string $apiMethod, array $fields = [], array $requestBody = [], array $headers = []): self
    {
        $requestUrl = sprintf(
            '%s%s',
            $this->getClearApiUrl(),
            $apiMethod
        );

        if (!empty($fields)) {
            $requestUrl .= '?' . http_build_query($fields);
        }

        if ($this->isInHeaders('Content-Type', $headers) === false) {
            $headers[] = 'Content-Type: ' . $this->contentType;
        }

        Logger::log(
            'Outgoing request',
            vsprintf(
                "URL: %s \n Method: %s \n Fields: %s \n RequestBody: %s \n Headers: %s",
                [$requestUrl, $requestMethod, json_encode($fields), json_encode($requestBody), json_encode($headers)]
            )
        );
        $this->curl
            ->setRequestUrl($requestUrl)
            ->setPostData($requestBody)
            ->setMethod($requestMethod)
            ->setHeader($headers)
            ->sendRequest();
        Logger::log(
            'Request response',
            sprintf("Fields: %s \n HTTP code: %s", $this->getResult(), $this->getHttpResponseCode())
        );
        $this->curl->checkResponse();

        return $this;
    }

    protected function getClearApiUrl(): string
    {
        if (!str_ends_with($this->apiUrl, '/')) {
            return $this->apiUrl . '/';
        }

        return $this->apiUrl;
    }

    private function isInHeaders(string $key, array $headers): bool
    {
        foreach ($headers as $header) {
            if (stripos($header, $key) !== false) {
                return true;
            }
        }

        return false;
    }
}