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

namespace Rakuten\Connector\Parsers\DirectPayment\CreditCard;

use Rakuten\Connector\Domains\Requests\Requests;
use Rakuten\Connector\Resources\Log\Logger;

/**
 * Trait Billing
 * @package Rakuten\Connector\Parsers\DirectPayment\CreditCard
 */
trait Billing
{
    /**
     * @param Requests $request
     * @param $properties
     * @return array
     */
    public static function getData(Requests $request, $properties)
    {
        Logger::info('Processing getData in trait Billing.');
        $data = [];
        // Billing data
        if (!is_null($request->getBilling())) {
            if (!is_null($request->getBilling()->getAddress())) {
                $data = array_merge($data, self::address($request->getBilling()->getAddress(), $properties));
            }
        }
        return $data;
    }

    /**
     * @param $request
     * @param $properties
     * @return array
     */
    private static function address($request, $properties)
    {
        $data = [];

        if (!is_null($request->getStreet())) {
            $data[$properties::BILLING_ADDRESS_STREET] = $request->getStreet();
        }
        if (!is_null($request->getNumber())) {
            $data[$properties::BILLING_ADDRESS_NUMBER] = $request->getNumber();
        }
        if (!is_null($request->getComplement())) {
            $data[$properties::BILLING_ADDRESS_COMPLEMENT] = $request->getComplement();
        }
        if (!is_null($request->getCity())) {
            $data[$properties::BILLING_ADDRESS_CITY] = $request->getCity();
        }
        if (!is_null($request->getState())) {
            $data[$properties::BILLING_ADDRESS_STATE] = $request->getState();
        }
        if (!is_null($request->getDistrict())) {
            $data[$properties::BILLING_ADDRESS_DISTRICT] = $request->getDistrict();
        }
        if (!is_null($request->getPostalCode())) {
            $data[$properties::BILLING_ADDRESS_POSTAL_CODE] = $request->getPostalCode();
        }
        if (!is_null($request->getCountry())) {
            $data[$properties::BILLING_ADDRESS_COUNTRY] = $request->getCountry();
        }
   
        return $data;
    }
}
