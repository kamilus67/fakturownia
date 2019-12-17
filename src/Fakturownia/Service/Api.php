<?php

namespace PiSystems\Fakturownia\Service;

/**
 * Class Api
 * @package PiSystems\Fakturownia\Service
 *
 * Author: PiSystems <kontakt@pisystems.pl
 * Description: Class for connect with API Fakturownia.pl
 */
class Api
{
    public $apiUrl = "https://YOUR_DOMAIN.fakturownia.pl/";
    public $apiToken = "API_TOKEN";

    /**
     * @param $url
     * @param $method
     * @param array $headers
     * @param null $content
     * @return bool|string
     * @throws \Exception
     *
     * Description: Call to API
     */
    protected function call($url, $method, $headers = [], $content = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl.$url);

        if($method == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
        } elseif($method != "GET") {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }

        if(count($headers) > 0) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        if($content != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        $error = curl_error($ch);
        $info = curl_getinfo($ch);
        curl_close($ch);

        if(strlen($error) > 0) {
            throw new \Exception($error, ($info['http_code']) ?: 500);
        }

        return $result;
    }
}