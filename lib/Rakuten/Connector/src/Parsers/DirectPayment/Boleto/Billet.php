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

namespace Rakuten\Connector\Parsers\DirectPayment\Boleto;

use Rakuten\Connector\Parsers\Error;
use Rakuten\Connector\Parsers\Parser;
use Rakuten\Connector\Resources\Log\Logger;

/**
 * Class Billet
 * @package Rakuten\Connector\Parsers\DirectPayment\Boleto
 */
class Billet extends Error implements Parser
{
    public static function success(\Rakuten\Connector\Resources\Http\RakutenPay\Http $http)
    {
        $data = json_decode($http->getResponse(), true);

        return $data['html'];
    }

    public static function error(\Rakuten\Connector\Resources\Http\RakutenPay\Http $http)
    {
        Logger::error('Failed to obtain billet data.');
    }
}