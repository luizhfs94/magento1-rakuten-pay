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

namespace RakutenPay\Resources\Factory\Sender;

use RakutenPay\Enum\Properties\Current;

/**
 * Class Document
 * @package RakutenPay\Resources\Factory
 */
class Phone
{

    /**
     * @var \RakutenPay\Domains\Sender
     */
    private $sender;

    /**
     * Document constructor.
     */
    public function __construct($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param \RakutenPay\Domains\Phone $document
     * @return \RakutenPay\Domains\Sender
     */
    public function instance(\RakutenPay\Domains\Phone $phone)
    {
        $this->sender->setPhone($phone);
        return $this->sender;
    }

    /**
     * @param $array
     * @return \RakutenPay\Domains\Sender
     */
    public function withArray($array)
    {
        $properties = new Current;
        $phone = new \RakutenPay\Domains\Phone();
        $phone->setAreaCode($array['areaCode'])
              ->setNumber($array['number']);
        $this->sender->setPhone($phone);
        return $this->sender;
    }


    /**
     * @param $areaCode
     * @param $number
     * @return \RakutenPay\Domains\Sender
     */
    public function withParameters($areaCode, $number)
    {
        $phone = new \RakutenPay\Domains\Phone();
        $phone->setAreaCode($areaCode)
              ->setNumber($number);
        $this->sender->setPhone($phone);
        return $this->sender;
    }
}
