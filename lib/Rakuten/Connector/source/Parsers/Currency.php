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

namespace RakutenConnector\Parsers;

use RakutenConnector\Domains\Requests\Requests;
use RakutenConnector\Helpers;
use RakutenConnector\Resources\Log\Logger;

/**
 * Trait Currency
 * @package RakutenConnector\Parsers
 */
trait Currency
{
    /**
     * @param Requests $request
     * @param $properties
     * @return array
     */
    public static function getData(Requests $request, $properties)
    {
        Logger::info('Processing getData in trait Currency.');
        $data = [];
        // currency
        if (!is_null($request->getCurrency())) {
            $data[$properties::CURRENCY] = $request->getCurrency();
        }
        
        if (!is_null($request->getExtraAmount())) {
            $data[$properties::CURRENCY_EXTRA_AMOUNT] = Helpers\Currency::toDecimal($request->getExtraAmount());
        }
        
        return $data;
    }
}
