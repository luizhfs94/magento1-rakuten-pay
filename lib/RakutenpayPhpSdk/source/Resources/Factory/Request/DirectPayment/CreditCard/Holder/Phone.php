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

namespace RakutenPay\Resources\Factory\Request\DirectPayment\CreditCard\Holder;

use RakutenPay\Enum\Properties\Current;

/**
 * Class Document
 * @package RakutenPay\Resources\Factory
 */
class Phone
{

    /**
     * @var \RakutenPay\Domains\DirectPayment\CreditCard\Holder
     */
    private $holder;

    /**
     * Document constructor.
     */
    public function __construct($holder)
    {
        $this->holder = $holder;
    }

    /**
     * @param \RakutenPay\Domains\Phone $phone
     * @return \RakutenPay\Domains\DirectPayment\CreditCard\Holder
     */
    public function instance(\RakutenPay\Domains\Phone $phone)
    {
        $this->holder->setPhone($phone);
        return $this->holder;
    }

    /**
     * @param $array
     * @return \RakutenPay\Domains\DirectPayment\CreditCard\Holder
     */
    public function withArray($array)
    {
        $properties = new Current;
        $phone = new \RakutenPay\Domains\Phone();
        $phone->setAreaCode($array[$properties::SENDER_PHONE_AREA_CODE])
              ->setNumber($array[$properties::SENDER_PHONE_NUMBER]);
        $this->holder->setPhone($phone);
        return $this->holder;
    }


    /**
     * @param $areaCode
     * @param $number
     * @return \RakutenPay\Domains\DirectPayment\CreditCard\Holder
     */
    public function withParameters($areaCode, $number)
    {
        $phone = new \RakutenPay\Domains\Phone();
        $phone->setAreaCode($areaCode)
              ->setNumber($number);
        $this->holder->setPhone($phone);
        return $this->holder;
    }
}
