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

namespace RakutenPay\Parsers\Transaction\Checkout;

use RakutenPay\Parsers\Error;
use RakutenPay\Parsers\Parser;
use RakutenPay\Resources\Http;
use RakutenPay\Resources\Log\Logger;
use RakutenPay\Parsers\Transaction\Checkout\Response;

class Request extends Error implements Parser
{
    /**
     * @param \RakutenPay\Resources\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        Logger::info($http->getResponse(), ["service" => "HTTP_RESPONSE"]);
        $data = json_decode($http->getResponse(), true);

        $response = (new Response)
        ->setResult($data['result'])
        ->setPayments($data['payments']);

        return $response;
    }

    /**
     * @param \RakutenPay\Resources\Http $http
     * @return \RakutenPay\Domains\Error
     */
    public static function error(Http $http)
    {
        return parent::error($http);
    }
}