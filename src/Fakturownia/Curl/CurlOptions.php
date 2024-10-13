<?php

namespace PiSystems\Fakturownia\Curl;

class CurlOptions
{
    protected array $headers = [];
    private int $verifyHost = 0;
    private int $timeout = 30;
    private int $connectTimeout = 15;
    private bool $verifyPeer = false;
    private bool $verbose = true;
    private bool $post = true;
    private bool $returnTransfer = true;
    private bool $failOnError = false;
    private bool $followLocation = false;

    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function setConnectTimeout(int $timeout): self
    {
        $this->connectTimeout = $timeout;

        return $this;
    }

    public function setVerifyHost(int $verifyHost): self
    {
        $this->verifyHost = $verifyHost;

        return $this;
    }

    public function disableVerifyPeer(): self
    {
        $this->verifyPeer = false;

        return $this;
    }

    public function disableVerbose(): self
    {
        $this->verbose = false;

        return $this;
    }

    public function disablePost(): self
    {
        $this->post = false;

        return $this;
    }

    public function disableReturnTransfer(): self
    {
        $this->returnTransfer = false;

        return $this;
    }

    public function disableFailOnError(): self
    {
        $this->failOnError = false;

        return $this;
    }

    public function disableFollowLocation(): self
    {
        $this->followLocation = false;

        return $this;
    }

    public function enableVerifyPeer(): self
    {
        $this->verifyPeer = true;

        return $this;
    }

    public function enableVerbose(): self
    {
        $this->verbose = true;

        return $this;
    }

    public function enablePost(): self
    {
        $this->post = true;

        return $this;
    }

    public function enableReturnTransfer(): self
    {
        $this->returnTransfer = true;

        return $this;
    }

    public function enableFailOnError(): self
    {
        $this->failOnError = true;

        return $this;
    }

    public function enableFollowLocation(): self
    {
        $this->followLocation = true;

        return $this;
    }

    public function setHeader(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    public function getOptionsArray(): array
    {
        return [
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_FOLLOWLOCATION => $this->followLocation,
            CURLOPT_SSL_VERIFYHOST => $this->verifyHost,
            CURLOPT_SSL_VERIFYPEER => $this->verifyPeer,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_VERBOSE => $this->verbose,
            CURLOPT_POST => $this->post,
            CURLOPT_RETURNTRANSFER => $this->returnTransfer,
            CURLOPT_FAILONERROR => $this->failOnError,
        ];
    }
}