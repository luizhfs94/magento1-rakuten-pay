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

namespace Rakuten\Connector\Domains;

/**
 * Class Shipping
 * @package Rakuten\Connector\Domains
 */
class Shipping
{

    /**
     * Shipping address
     *
     * @see Address
     */
    private $address;

    /**
     * Shipping type. See the ShippingType class for a list of known shipping types.
     *
     * @see ShippingType
     */
    private $type;

    /***
     * Shipping cost.
     */
    private $cost;

    /**
     * Phone
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

    /**
     * @return string
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param string $cost
     * @return Shipping
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
        return $this;
    }

    /**
     * @return ShippingType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param ShippingType $type
     * @return Shipping
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    function getPhone() {
        return $this->phone;
    }

    function setPhone($phone) {
        $this->phone = $phone;
    }
}
