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

namespace RakutenPay\Parsers\DirectPayment\Boleto;

use RakutenPay\Parsers\Error;
use RakutenPay\Parsers\Parser;

class Billet extends Error implements Parser
{
    public static function success(\RakutenPay\Resources\Http $http) {
        $data = json_decode($http->getResponse(), true);
        return $data['html'];
    }

    public static function error(\RakutenPay\Resources\Http $http) {
        \RakutenPay\Resources\Log\Logger::error('Failed to obtain billet data.');
    }
}