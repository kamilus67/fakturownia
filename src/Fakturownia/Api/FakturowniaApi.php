<?php

namespace PiSystems\Fakturownia\Api;

use PiSystems\Fakturownia\Api\Invoices\InvoicesApi;
use RuntimeException;

class FakturowniaApi
{
    private null|InvoicesApi $invoices = null;

    public function __construct(
        private readonly string $apiUrl,
        private readonly string $tokenApi,
    )
    {
        if (!filter_var($apiUrl, FILTER_VALIDATE_URL)) {
            throw new RuntimeException(sprintf('Invalid URL provided: %s', $apiUrl));
        }
    }

    public function invoices(): InvoicesApi
    {
        if (is_null($this->invoices)) {
            $this->invoices = new InvoicesApi($this->apiUrl, $this->tokenApi);
        }

        return $this->invoices;
    }
}