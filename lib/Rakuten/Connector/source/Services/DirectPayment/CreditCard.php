<?php
/**
 ************************************************************************
 * Copyright [2017] [RakutenConnector]
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

namespace RakutenConnector\Services\DirectPayment;

use RakutenConnector\Domains\Account\Credentials;
use RakutenConnector\Helpers\Crypto;
use RakutenConnector\Parsers\DirectPayment\CreditCard\Request;
use RakutenConnector\Resources\Connection;
use RakutenConnector\Resources\RakutenPay\Http;
use RakutenConnector\Resources\Log\Logger;
use RakutenConnector\Resources\Responsibility;

/**
 * Class CreditCard
 * @package RakutenConnector\Services\DirectPayment
 */
class CreditCard
{
    /**
     * @param \RakutenConnector\Domains\Account\Credentials $credentials
     * @param \RakutenConnector\Domains\Requests\DirectPayment\OnlineDebit $payment
     * @return string
     * @throws \Exception
     */
    public static function checkout(
        \RakutenConnector\Domains\Requests\DirectPayment\CreditCard $payment
    ) {
        Logger::info("Begin", ['service' => 'DirectPayment.CreditCard']);
        try {
            $connection = new Connection\Data();
            $http = new Http();
            Logger::info(sprintf("POST: %s", self::request($connection)), ['service' => 'DirectPayment.CreditCard']);
            Logger::info(
                sprintf(
                    "Params: %s",
                    json_encode(Crypto::encrypt(Request::getData($payment)))
                ),
                ['service' => 'Checkout']
            );
            $http->post(
                self::request($connection),
                Request::getData($payment)
            );

            $response = Responsibility::http(
                $http,
                new Request
            );

            return $response;
        } catch (\Exception $exception) {
            Logger::error($exception->getMessage(), ['service' => 'DirectPayment.CreditCard']);
            throw $exception;
        }
    }

    /**
     * @param Connection\Data $connection
     * @return string
     */
    private static function request(Connection\Data $connection)
    {
        return $connection->buildDirectPaymentRequestUrl();
    }
}
