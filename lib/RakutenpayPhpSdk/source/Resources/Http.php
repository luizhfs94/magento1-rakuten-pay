<?php
/**
 ************************************************************************
 * Copyright [2017] [RakutenPay]
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ************************************************************************
 */

namespace RakutenPay\Resources;

use RakutenPay\Helpers\JsonFormat;
use RakutenPay\Resources\Log\Logger;

/**
 * Class Http
 * @package RakutenPay\Resources
 */
class Http
{
    /**
     * @var
     */
    private $status;
    /**
     * @var
     */
    private $response;

    /**
     * Http constructor.
     */
    public function __construct()
    {
        Logger::info('Constructing Http.');
        if (!function_exists('curl_init')) {
            throw new \Exception('RakutenPay Library: cURL library is required.');
        }
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param $url
     * @param array $data
     * @param int $timeout
     * @param string $charset
     * @return bool
     * @throws \Exception
     */
    public function post($url, array $data = array(), $timeout = 20, $charset = 'ISO-8859-1')
    {
        Logger::info('Processing post.');
        return $this->curlConnection('POST', $url, $timeout, $charset, $data);
    }

    /**
     * @param $url
     * @param int $timeout
     * @param string $charset
     * @return bool
     * @throws \Exception
     */
    public function get($url, $timeout = 20, $charset = 'ISO-8859-1', $secureGet = true)
    {
        return $this->curlConnection('GET', $url, $timeout, $charset, null, $secureGet);
    }

    /**
     * @param $method
     * @param $url
     * @param $timeout
     * @param $charset
     * @param array|null $data
     * @return bool
     * @throws \Exception
     */
    private function curlConnection($method, $url, $timeout, $charset, array $data = null, $secureGet = true)
    {
        Logger::info('Processing curlConnection.');
        $cnpj = \Mage::getStoreConfig('payment/rakutenpay/cnpj');
        $api_key = \Mage::getStoreConfig('payment/rakutenpay/api_key');
        $auth = $cnpj . ':' . $api_key;
        $auth_base64 = base64_encode($auth);
        if (strtoupper($method) === 'POST') {
            $postData = JsonFormat::getJson($data);

            Logger::info(sprintf("POST: %s", $postData), ['service' => 'HTTP_POST']);
            $sig_key = \Mage::getStoreConfig('payment/rakutenpay/signature_key');
            $signature = hash_hmac('sha256', $postData, $sig_key, true);
            $signature_base64 = base64_encode($signature);
            $methodOptions = array(
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Signature: ' . $signature_base64,
                    'Authorization: Basic ' . $auth_base64,
                    'Cache-Control: no-cache'
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postData,
            );
        } else {
            Logger::info(sprintf('Processing Request. URL %s', $url), ['service' => $method]);
            $methodOptions = array(
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $auth_base64,
                    'Cache-Control: no-cache'
                ],
                CURLOPT_HTTPGET => true
            );
        }

        $options = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            //CURLOPT_TIMEOUT => $timeout
        );

        $options = ($options + $methodOptions);
        $curl = curl_init();
        curl_setopt_array($curl, $options);
        $resp = curl_exec($curl);
        $info = curl_getinfo($curl);
        if (array_key_exists('signature', $info)) {
            Logger::info('Checking response signature.', ['service' => 'HTTP.Response.Signature']);
            $sig_key = \Mage::getStoreConfig('payment/rakutenpay/signature_key');
            $signature = hash_hmac('sha256', $postData, $sig_key, true);
            $signature_base64 = base64_encode($signature);
            if ($info['signature'] !== $signature_base64) {
                Logger::error("Wrong signature from RakutenPay.");
                throw new \Exception("Wrong signature from RakutenPay.");
            }
        } elseif ($secureGet and strtoupper($method) === 'GET') {
            Logger::error("No signature from RakutenPay.");
            throw new \Exception("No signature from RakutenPay.");
        } else {
            Logger::info('No signature in header.', ['service' => 'HTTP.Response.Signature']);
        }
        $error = curl_errno($curl);
        $errorMessage = curl_error($curl);
        curl_close($curl);
        $this->setStatus((int) $info['http_code']);
        $this->setResponse((String) $resp);
        Logger::info(sprintf('Response Status: %s', $this->getStatus()), ['service' => 'HTTP.Response.Status']);
        if ($error) {
            if (strpos($errorMessage, 'transfer closed with') !== false) {
                Logger::info(sprintf('CURL: %s', $errorMessage, ['service' => 'HTTP.Response']));
                return true;
            }
            throw new \Exception("CURL can't connect: $errorMessage");
        } else {
            return true;
        }
    }
}
