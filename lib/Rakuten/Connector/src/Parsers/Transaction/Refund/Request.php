<?php
/**
 ************************************************************************
 * Copyright [2018] [RakutenConnector]
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

namespace Rakuten\Connector\Parsers\Transaction\Refund;

use Rakuten\Connector\Enum\Properties\Current;
use Rakuten\Connector\Parsers\Error;
use Rakuten\Connector\Parsers\Parser;
use Rakuten\Connector\Resources\Http\RakutenPay\Http;
use Rakuten\Connector\Parsers\Transaction\Refund\Response;

/**
 * Class Request
 * @package Rakuten\Connector\Parsers\Transaction\Refund
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
     * @param \Rakuten\Connector\Resources\Http\RakutenPay\Http $http
     * @return Response
     */
    public static function success(Http $http)
    {
        $json = json_decode($http->getResponse(), true);
        $result = new Response();
        $result->setResult($json);
        return $result;
    }

    /**
     * @param \Rakuten\Connector\Resources\Http\RakutenPay\Http $http
     * @return \RakutenPay\Domains\Error
     */
    public static function error(Http $http)
    {
        $error = parent::error($http);
        return $error;
    }
}
