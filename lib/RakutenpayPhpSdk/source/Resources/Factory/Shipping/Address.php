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

namespace RakutenPay\Resources\Factory\Shipping;

use RakutenPay\Enum\Properties\Current;

/**
 * Class Shipping
 * @package RakutenPay\Resources\Factory\Request
 */
class Address
{

    /**
     * @var \RakutenPay\Domains\Shipping
     */
    private $shipping;

    /**
     * Shipping constructor.
     * @param $shipping
     */
    public function __construct($shipping)
    {
        $this->shipping = $shipping;
    }

    /**
     * @param \RakutenPay\Domains\Addres $address
     * @return \RakutenPay\Domains\Shipping
     */
    public function instance(\RakutenPay\Domains\Address $address)
    {
        $this->shipping->setAddress($address);
        return $this->shipping;
    }

    /**
     * @param $array
     * @return \RakutenPay\Domains\Shipping
     */
    public function withArray($array)
    {
        $properties = new Current;
        $address = new \RakutenPay\Domains\Address();
        $address->setPostalCode($array[$properties::SHIPPING_ADDRESS_POSTAL_CODE])
                ->setStreet($array[$properties::SHIPPING_ADDRESS_STREET])
                ->setNumber($array[$properties::SHIPPING_ADDRESS_NUMBER])
                ->setComplement($array[$properties::SHIPPING_ADDRESS_COMPLEMENT])
                ->setDistrict($array[$properties::SHIPPING_ADDRESS_DISTRICT])
                ->setCity($array[$properties::SHIPPING_ADDRESS_CITY])
                ->setState($array[$properties::SHIPPING_ADDRESS_STATE])
                ->setCountry($array[$properties::SHIPPING_ADDRESS_COUNTRY])
                ->setPhone($array[$properties::SHIPPING_ADDRESS_PHONE]);
        $this->shipping->setAddress($address);
        return $this->shipping;
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
     * @return \RakutenPay\Domains\Shipping
     */
    public function withParameters(
        $street,
        $number,
        $district,
        $postalCode,
        $city,
        $state,
        $country,
        $phone,
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
                ->setPhone($phone)
                ->setCountry($country);
        $this->shipping->setAddress($address);
        $this->shipping->setPhone($phone);
        return $this->shipping;
    }
}
