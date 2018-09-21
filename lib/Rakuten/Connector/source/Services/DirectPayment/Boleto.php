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

use RakutenConnector\Resources\Connection;
use RakutenConnector\Resources\RakutenPay\Http;
use RakutenConnector\Resources\Log\Logger;
use RakutenConnector\Resources\Responsibility;
use RakutenConnector\Parsers\DirectPayment\Boleto\Request;
use RakutenConnector\Helpers\Crypto;

/**
 * Class Boleto
 * @package RakutenConnector\Services\DirectPayment
 */
class Boleto
{

    /**
     * @param \RakutenConnector\Domains\Requests\DirectPayment\Boleto $payment
     * @return string
     * @throws \Exception
     */
    public static function checkout(
        \RakutenConnector\Domains\Requests\DirectPayment\Boleto $payment
    ) {
        Logger::info("Begin", ['service' => 'DirectPayment.Boleto']);
        try {
            $connection = new Connection\Data();
            $http = new Http();
            Logger::info(sprintf("POST: %s", self::request($connection)), ['service' => 'DirectPayment.Boleto']);
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

            Logger::info(
                sprintf("Boleto Payment Link URL: %s", $response->getBillet()),
                ['service' => 'DirectPayment.Boleto']
            );

            return $response;
        } catch (\Exception $exception) {
            Logger::error($exception->getMessage(), ['service' => 'Session']);
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
