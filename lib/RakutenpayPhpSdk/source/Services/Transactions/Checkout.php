<?php
/**
 ************************************************************************
 * Copyright [2018] [RakutenPay]
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

namespace RakutenPay\Services\Transactions;

use RakutenPay\Enum\Properties\Current;
use RakutenPay\Resources\Log\Logger;
use RakutenPay\Resources\Connection;
use RakutenPay\Resources\Http;
use RakutenPay\Resources\Responsibility;
use RakutenPay\Parsers\Transaction\Checkout\Request;

class Checkout
{
    public static function get(
        array $options
    )
    {
        Logger::info("Begin", ['service' => 'Transactions.Checkout']);
        try {
            $connection = new Connection\Data();
            $http = new Http();
            Logger::info(sprintf("GET: %s", self::request($connection, $options)));

            $http
            ->get(self::request($connection, $options), 20, 'ISO-8859-1', false);

            return Responsibility::http(
                $http,
                new Request
            );            
        }
        catch (\Exception $exception) {
            Logger::error($exception->getMessage(), ['service' => 'Session']);
            throw $exception;
        }
    }

    private static function request(Connection\Data $connection, $params)
    {
        return sprintf(
            "%s/?%s",
            $connection->buildCheckoutUrl(),
            sprintf("%s=%s", Current::INSTALLMENT_AMOUNT, $params["amount"])
        );
    }
}