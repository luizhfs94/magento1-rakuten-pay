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

namespace RakutenConnector\Resources\Factory\Request;

use RakutenConnector\Enum\Properties\Current;

/**
 * Class PaymentMethod
 * @package RakutenConnector\Resources\Factory\Request
 */
class PaymentMethod
{
    private $paymentMethod = array();

    public function instance(\RakutenConnector\Domains\PaymentMethod $paymentMethod)
    {
        return $paymentMethod;
    }

    public function withArray($array)
    {
        $properties = new Current;

        $paymentMethod = new \RakutenConnector\Domains\PaymentMethod();
        $paymentMethod->setKey($array[$properties::PAYMENT_METHOD_CONFIG_KEY])
             ->setValue($array[$properties::PAYMENT_METHOD_CONFIG_VALUE])
             ->setGroup($array[$properties::PAYMENT_METHOD_GROUP]);

        array_push($this->paymentMethod, $paymentMethod);
        return $this->paymentMethod;
    }

    public function withParameters(
        $group,
        $key,
        $value
    ) {
        $paymentMethod = new \RakutenConnector\Domains\PaymentMethod();
        $paymentMethod->setKey($key)
            ->setValue($value)
            ->setGroup($group);
        array_push($this->paymentMethod, $paymentMethod);
        return $this->paymentMethod;
    }
}
