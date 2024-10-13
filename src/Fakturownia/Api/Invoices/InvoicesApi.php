<?php

namespace PiSystems\Fakturownia\Api\Invoices;

use PiSystems\Fakturownia\Api\ApiAction;
use PiSystems\Fakturownia\Enum\Invoice\Status;

class InvoicesApi extends ApiAction
{
    public function create(array $data): array
    {
        return $this->run(static::POST, 'invoices.json', [], [
            'api_token' => $this->tokenApi,
            'invoice' => $data
        ]);
    }

    public function update(int $invoiceId, array $data): array
    {
        return $this->run(static::PUT, sprintf('invoices/%s.json', $invoiceId), [], [
            'api_token' => $this->tokenApi,
            'invoice' => $data
        ]);
    }

    public function changeStatus(int $invoiceId, Status $status): bool
    {
        $this->run(
            static::POST,
            sprintf('invoices/%s/change_status.json', $invoiceId),
            [
                'api_token' => $this->tokenApi,
                'status' => $status->value
            ]
        );

        return $this->curl->getHttpResponseCode() === 200;
    }

    public function delete(int $invoiceId): bool
    {
        $result = $this->run(static::DELETE, sprintf('invoices/%s.json', $invoiceId), [
            'api_token' => $this->tokenApi,
        ]);

        return ($result[0] ?? '') === 'ok';
    }

    public function cancel(int $invoiceId, array $additionalData = []): bool
    {
        $result = $this->run(
            static::POST,
            'invoices/cancel.json',
            [],
            array_merge([
                'api_token' => $this->tokenApi,
                'cancel_invoice_id' => $invoiceId,
            ], $additionalData)
        );

        return ($result['code'] ?? '') === 'success';
    }

    public function getWebLink(int $invoiceId): string|null
    {
        $result = $this->run(static::GET, sprintf('invoices/%s.json', $invoiceId), [
            'api_token' => $this->tokenApi,
        ]);

        if (empty($result['token'])) {
            return null;
        }

        return sprintf('%sinvoice/%s', $this->getClearApiUrl(), $result['token']);
    }

    public function getPdfLink(int $invoiceId, bool $inline): string|null
    {
        $result = $this->run(static::GET, sprintf('invoices/%s.json', $invoiceId), [
            'api_token' => $this->tokenApi,
        ]);

        if (empty($result['token'])) {
            return null;
        }

        $pdfLinkFormat = '%sinvoice/%s.pdf';

        if ($inline === true) {
            $pdfLinkFormat .= '?inline=yes';
        }

        return sprintf($pdfLinkFormat, $this->getClearApiUrl(), $result['token']);
    }
}