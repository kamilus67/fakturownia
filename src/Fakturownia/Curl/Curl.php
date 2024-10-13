<?php

namespace PiSystems\Fakturownia\Curl;

use CurlHandle;
use Exception;

class Curl extends CurlOptions
{
    public const HTTP_SUCCESS_CODES = [
        200 => 'OK - default successful outcome of the request',
        201 => 'Created - successfully created a new object',
        202 => 'Accepted - successfully created a new object, but requires further action',
    ];

    public const HTTP_ERROR_CODES = [
        400 => 'Bad Request - request could not be accepted, either due to missing required parameters or one of the
         parameters not passing through validation',
        401 => 'Unauthorized - authorization failed, the request has not been applied because it lacks valid
         authentication credentials for the target resource',
        403 => 'Forbidden - authorization access scope does not allow to fulfill this operation',
        404 => 'Not Found - object with requested ID could not be found',
        405 => 'Method Not Allowed - request is not supported for the path, for example attempting to use POST on list
         endpoint that doesn\'t allow creating a new object',
        409 => 'Conflict - conflict with existing objects, for example attempting to create two objects with the same
         data, or executing two incompatible operations on a single object',
        422 => 'Unprocessable Entity - the request was well-formed but was unable to be followed due to semantic 
         errors',
    ];

    private null|array $curlInfo = null;

    private string $curlError = '';

    private string $curlErrorNumber = '';

    private string $url = '';

    private array $postData = [];

    private string $method = '';

    private string|bool $result;

    public function __construct()
    {
        if (!function_exists('curl_init') || !function_exists('curl_exec')) {
            throw new Exception('cURL function not available');
        }
    }

    public function setRequestUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function setPostData(array $postData): self
    {
        $this->postData = $postData;

        return $this;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getCurlLastInfo(): null|array
    {
        return $this->curlInfo;
    }

    public function getCurlLastError(): string
    {
        return $this->curlError;
    }

    public function getCurlLastErrorNo(): string
    {
        return $this->curlErrorNumber;
    }

    public function getHttpResponseCode(): int
    {
        return $this->curlInfo['http_code'];
    }

    public function getHttpResponseContentType(): string
    {
        return $this->curlInfo['content_type'];
    }

    public function getResult(): string|bool
    {
        return $this->result;
    }

    public function getHttpResponseMessage(): string
    {
        $responseCode = $this->getHttpResponseCode();
        $errorCodesDict = self::HTTP_ERROR_CODES;
        $successCodesDict = self::HTTP_SUCCESS_CODES;
        if (array_key_exists($responseCode, $errorCodesDict)) {
            return $errorCodesDict[$responseCode];
        }
        if (array_key_exists($responseCode, $successCodesDict)) {
            return $successCodesDict[$responseCode];
        }

        return 'Not supported response from Fakturownia server';
    }

    public function init(): CurlHandle
    {
        $ch = curl_init();
        foreach ($this->getOptionsArray() as $key => $value) {
            curl_setopt($ch, $key, $value);
        }
        curl_setopt($ch, CURLOPT_URL, $this->url);
        $this->setCurlMethod($ch);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        return $ch;
    }

    public function sendRequest(): self
    {
        $ch = $this->init();
        $curlRes = curl_exec($ch);
        $this->curlInfo = curl_getinfo($ch);
        $this->curlError = curl_error($ch);
        $this->curlErrorNumber = curl_errno($ch);
        curl_close($ch);
        $this->result = $curlRes;

        return $this;
    }

    public function checkResponse(): void
    {
        $responseCode = $this->curlInfo['http_code'];

        if ($responseCode >= 200 && $responseCode <= 299) {
            return;
        }

        if (array_key_exists($responseCode, self::HTTP_ERROR_CODES)) {
            $codeDescription = sprintf('Fakturownia return %s', self::HTTP_ERROR_CODES[$responseCode]);
            throw new Exception($codeDescription);
        }

        throw new Exception(sprintf('Unexpected response from Fakturownia %s', $responseCode));
    }

    private function setCurlMethod(CurlHandle $curl): void
    {
        switch ($this->method) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, 1);
                if (!empty($this->postData)) {
                    $json = json_encode($this->postData);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                }
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                if (!empty($this->postData)) {
                    $json = json_encode($this->postData);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                }
                break;
            case 'DELETE':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($this->postData)) {
                    $json = json_encode($this->postData);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
                }
                break;
            case 'GET':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
                break;
            default:
                throw new Exception(sprintf('Curl method %s is not allowed', $this->method));
        }
    }
}