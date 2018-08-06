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

namespace RakutenPay\Resources\Factory\Request\DirectPayment\CreditCard\Billing;

use RakutenPay\Enum\Properties\Current;

/**
 * Class Shipping
 * @package RakutenPay\Resources\Factory\Request
 */
class Address
{

    /**
     * @var \RakutenPay\Domains\DirectPayment\CreditCard\Billing
     */
    private $billing;

    /**
     * Shipping constructor.
     * @param $billing
     */
    public function __construct($billing)
    {
        $this->billing = $billing;
    }

    /**
     * @param \RakutenPay\Domains\Address $address
     * @return \RakutenPay\Domains\DirectPayment\CreditCard\Billing
     */
    public function instance(\RakutenPay\Domains\Address $address)
    {
        $this->billing->setAddress($address);
        return $this->billing;
    }

    /**
     * @param $array
     * @return \RakutenPay\Domains\DirectPayment\CreditCard\Billing
     */
    public function withArray($array)
    {
        $properties = new Current;
        $address = new \RakutenPay\Domains\Address();
        $address->setPostalCode($array[$properties::SHIPPING_ADDRESS_POSTAL_CODE])
                ->setName($array[$properties::SHIPPING_ADDRESS_NAME])
                ->setStreet($array[$properties::SHIPPING_ADDRESS_STREET])
                ->setNumber($array[$properties::SHIPPING_ADDRESS_NUMBER])
                ->setComplement($array[$properties::SHIPPING_ADDRESS_COMPLEMENT])
                ->setDistrict($array[$properties::SHIPPING_ADDRESS_DISTRICT])
                ->setCity($array[$properties::SHIPPING_ADDRESS_CITY])
                ->setState($array[$properties::SHIPPING_ADDRESS_STATE])
                ->setCountry($array[$properties::SHIPPING_ADDRESS_COUNTRY])
                ->setPhone($array[$properties::SHIPPING_ADDRESS_PHONE]);
        $this->billing->setAddress($address);
        return $this->billing;
    }

    /**
     * @param $street
     * @param $number
     * @param null $complement
     * @param $district
     * @param $postalCode
     * @param $city
     * @param $state
     * @param $country
     * @return \RakutenPay\Domains\DirectPayment\CreditCard\Billing
     */
    public function withParameters(
        $street,
        $number,
        $district,
        $postalCode,
        $city,
        $state,
        $country,
        $complement = null
    ) {
        $address = new \RakutenPay\Domains\Address();
        $address->setPostalCode($postalCode)
                ->setStreet($street)
                ->setNumber($number)
                ->setComplement($complement)
                ->setDistrict($district)
                ->setCity($city)
                ->setState($state)
                ->setCountry($country);
        $this->billing->setAddress($address);
        return $this->billing;
    }
}
