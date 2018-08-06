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

namespace RakutenPay\Domains\DirectPayment\CreditCard;

class Billing
{

    /***
     * Billing address
     * @see Address
     */
    private $address;

    /**
     * Billing phone
     */
    private $phone;

    /**
     * @return Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Shipping
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    function getPhone() {
        return $this->phone;
    }

    function setPhone($phone) {
        $this->phone = $phone;
        return $this;
    }
}
