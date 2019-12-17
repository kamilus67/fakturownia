<?php

namespace PiSystems\Fakturownia;

use PiSystems\Fakturownia\Service\Api;

/**
 * Class Fakturownia
 * @package PiSystems\Fakturownia
 *
 * Author: PiSystems <kontakt@pisystems.pl
 * Description: Library for set/get invoices into Fakturownia.pl
 */
class Fakturownia extends Api
{
    /**
     * @param array $invoice
     * @return bool|string
     * @throws \Exception
     *
     * Description: Create invoice
     */
    public function setInvoice($invoice) {
        $result = $this->call("invoices.json", "POST", [
            "Accept: application/json",
            "Content-Type: application/json"
        ], json_encode([
            "api_token" => $this->apiToken,
            "invoice" => $invoice
        ]));

        $resultDecode = json_decode($result, true);

        if(isset($resultDecode['code']) && $resultDecode['code'] == 'error') {
            throw new \Exception($resultDecode['message']);
        }

        return $result;
    }

    /**
     * @param array $data
     * @return bool|string
     * @throws \Exception
     *
     * Description: Get invoice data by parametes in param $data - invoiceNo (number of invoice), invoiceId (internal ID Fakturownia.pl)
     */
    public function getInvoice($data) {
        if((!isset($data['invoiceId']) || empty($data['invoiceId'])) && (!isset($data['invoiceNo']) || empty($data['invoiceNo']))) {
            throw new \Exception("invoiceId or invoiceNo is required");
        }

        $result = false;
        if(isset($data['invoiceId']) || !empty($data['invoiceId'])) {
            $result = $this->call("invoices/".$data['invoiceId'].".json?api_token=".$this->apiToken, "GET", [], null);
        } elseif(isset($data['invoiceNo']) || !empty($data['invoiceNo'])) {
            $result = $this->call("invoices.json?number=".$data['invoiceNo']."&api_token=".$this->apiToken, "GET", [], null);
        } else {
            throw new \Exception("Error not handle");
        }

        if($result == false) {
            throw new \Exception("invoiceId or invoiceNo is required");
        }

        $resultDecode = json_decode($result, true);

        if(isset($resultDecode['code']) && $resultDecode['code'] == 'error') {
            throw new \Exception($resultDecode['message']);
        }

        if(isset($data['invoiceNo']) || !empty($data['invoiceNo'])) {
            $result = $this->getInvoice([
                "invoiceId" => reset($resultDecode)['id']
            ]);
        }

        return $result;
    }

    /**
     * @param $data
     * @return false|mixed|string
     * @throws \Exception
     *
     * Description: Get invoice PDF by parametes in param $data - invoiceNo (number of invoice), invoiceId (internal ID Fakturownia.pl)
     */
    public function getInvoicePdf($data) {
        try {
            $result = json_decode($this->getInvoice($data), true);
        } catch(\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        $result = file_get_contents($this->apiUrl."invoices/".$result['id'].".pdf?api_token=".$this->apiToken);

        return $result;
    }
}

// setInvoice sample array
//[
//    "income"                    => 1,
//    "department_id"             => "642374",
//    "kind"                      => "vat",
//    "sell_date"                 => "2019-12-16",
//    "issue_date"                => "2019-12-16",
//    "payment_to"                => "2019-12-23",
//    "payment_type"              => "transfer",
//    "status"                    => "issued",
//    //"paid"                      => "100",
//    //"paid_date"                 => "2019-12-23",
//
//    "buyer_name"                => "Company Inc.",
//    "buyer_tax_no"              => "1234567890",
//    "buyer_tax_no_kind"         => "NIP",
//    "buyer_post_code"           => "01-001",
//    "buyer_city"                => "Warsaw",
//    "buyer_street"              => "Al. Jerozolimskie 10/12",
//    "buyer_country"             => "PL",
//    "buyer_email"               => "company@gmail.com",
//
//    "positions" => [
//        [
//            "name"              => "Produkt A",
//            "quantity"          => 1,
//            "quantity_unit"     => "szt",
//            "total_price_gross" => "123",
//            "tax"               => 23
//        ]
//    ]
//]

// getInvoice and getInvoicePdf sample array
//[
//    "invoiceId" => "5364588789",
//    "invoiceNo" => "FVS/1/12/2019"
//]