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

namespace Rakuten\Connector\Parsers\DirectPayment\Boleto;

use Rakuten\Connector\Resources\Log\Logger;
use Rakuten\Connector\Enum\DirectPayment\Method;
use Mage;

/**
 * Trait Payment
 * @package Rakuten\Connector\Parsers\DirectPayment\Boleto
 */
trait Payment
{
    /**
     * @param $request
     * @param $properties
     * @return array
     */
    public static function getData($request, $properties)
    {
        Logger::info('Processing getData in trait Payment.');
        $data = [];
        $payment_array = [];
        $payment_values = [];

        //method
        $payment_values[$properties::DIRECT_PAYMENT_METHOD] = Method::BOLETO;
        //amount
        if (method_exists($request, 'getTotal') and ! is_null($request->getTotal())) {
            $payment_values[$properties::AMOUNT] = floatval($request->getTotal());
        }
        //expires_on
        $today = date('Y-m-d');
        $days = Mage::getStoreConfig('payment/rakutenpay_boleto/expiration');
        if ($days) {
            $days = intval($days);
        }
        if (!$days) {
            $days = 5;
        }
        $payment_values[$properties::EXPIRES_ON] = date('Y-m-d', strtotime($today. ' + ' . $days . ' days'));
        $payment_array[] = $payment_values;
        $data[$properties::PAYMENTS] = $payment_array;
        return $data;
    }
}
