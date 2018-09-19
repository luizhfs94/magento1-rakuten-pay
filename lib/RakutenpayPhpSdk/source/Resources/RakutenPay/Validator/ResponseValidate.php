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

namespace RakutenPay\Resources\RakutenPay\Validator;

use RakutenPay\Enum\Http\Status;
use RakutenPay\Resources\Log\Logger;
use Mage;

/**
 * Class ResponseValidate
 * @package RakutenPay\Resources\RakutenPay\Validator
 */
class ResponseValidate
{
    /**
     * @param $method
     * @param $info
     * @param $data
     * @param $secureGet
     * @throws \Exception
     */
    public static function validateSignature($method, $info, $data, $secureGet)
    {
        if (is_array($info) && array_key_exists('signature', $info)) {
            Logger::info('Checking response signature.', ['service' => 'HTTP.Response.Signature']);
            $sigKey = Mage::getStoreConfig('payment/rakutenpay/signature_key');
            $signature = hash_hmac('sha256', $data, $sigKey, true);
            $signatureBase64 = base64_encode($signature);

            if ($info['signature'] !== $signatureBase64) {
                Logger::error("Wrong signature from RakutenPay.");
                throw new \Exception("Wrong signature from RakutenPay.");
            }
        }

        if ($secureGet && strtoupper($method) === 'GET') {
            Logger::error("No signature from RakutenPay.");
            throw new \Exception("No signature from RakutenPay.");
        }
        Logger::info('No signature in header.', ['service' => 'HTTP.Response.Signature']);
    }

    /**
     * @param $status
     * @param $response
     * @param $error
     * @param $errorMessage
     * @return array
     * @throws \Exception
     */
    public static function checkErrors($status, $response, $error, $errorMessage)
    {
        $result = [
            'status' => (int) $status,
            'response' => (string) $response,
        ];

        if ($error) {
            Logger::info(sprintf('Processing checkErrors in ResponseValidate'));
            switch (true) {
                case self::hasTransferClosed($errorMessage):
                    return $result;
                case self::hasChargeAlreadyExists($errorMessage):
                    $result['status'] = Status::OK;
                    return $result;
                default:
                    throw new \Exception("CURL can't connect: $errorMessage");
            }
        }

        return $result;
    }

    /**
     * @param $errorMessage
     * @return bool
     */
    private static function hasTransferClosed($errorMessage)
    {
        if (strpos($errorMessage, 'transfer closed with') !== false) {
            Logger::info(sprintf('CURL: %s', $errorMessage, ['service' => 'HTTP.Response']));

            return true;
        }

        return false;
    }

    /**
     * @param $errorMessage
     * @return bool
     */
    private static function hasChargeAlreadyExists($errorMessage)
    {
        if (strpos($errorMessage, 'Charge already exists with authorized status') !== false) {
            Logger::info(sprintf('CURL: %s', $errorMessage, ['service' => 'HTTP.Response']));

            return true;
        }

        return false;
    }

}
