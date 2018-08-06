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

namespace RakutenPay\Parsers\Transaction\Refund;

use RakutenPay\Enum\Properties\Current;
use RakutenPay\Parsers\Error;
use RakutenPay\Parsers\Parser;
use RakutenPay\Resources\Http;

/**
 * Class Payment
 * @package RakutenPay\Parsers\Checkout
 */
class Request extends Error implements Parser
{


    /**
     * @param $code
     * @param $value
     * @return array
     */
    public static function getData($code, $value)
    {
        $data = [];
        $properties = new Current;

        if (!is_null($code)) {
            $data[$properties::TRANSACTION_CODE] = $code;
        }

        if (!is_null($value)) {
            $data[$properties::REFUND_VALUE] = $value;
        }

        return $data;
    }

    /**
     * @param \RakutenPay\Resources\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        $json = json_decode($http->getResponse(), true);
        $result = new \RakutenPay\Parsers\Transaction\Refund\Response();
        $result->setResult($json);
        return $result;
    }

    /**
     * @param \RakutenPay\Resources\Http $http
     * @return \RakutenPay\Domains\Error
     */
    public static function error(Http $http)
    {
        $error = parent::error($http);
        return $error;
    }
}
