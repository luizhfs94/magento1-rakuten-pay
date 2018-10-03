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

namespace Rakuten\Connector\Resources\Factory\Sender;

use Rakuten\Connector\Enum\Properties\Current;

/**
 * Class Phone
 * @package Rakuten\Connector\Resources\Factory\Sender
 */
class Phone
{

    /**
     * @var \Rakuten\Connector\Domains\Sender
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
     * @param \Rakuten\Connector\Domains\Phone $document
     * @return \Rakuten\Connector\Domains\Sender
     */
    public function instance(\Rakuten\Connector\Domains\Phone $phone)
    {
        $this->sender->setPhone($phone);
        return $this->sender;
    }

    /**
     * @param $array
     * @return \Rakuten\Connector\Domains\Sender
     */
    public function withArray($array)
    {
        $properties = new Current;
        $phone = new \Rakuten\Connector\Domains\Phone();
        $phone->setAreaCode($array['areaCode'])
              ->setNumber($array['number']);
        $this->sender->setPhone($phone);
        return $this->sender;
    }


    /**
     * @param $areaCode
     * @param $number
     * @return \Rakuten\Connector\Domains\Sender
     */
    public function withParameters($areaCode, $number)
    {
        $phone = new \Rakuten\Connector\Domains\Phone();
        $phone->setAreaCode($areaCode)
              ->setNumber($number);
        $this->sender->setPhone($phone);
        return $this->sender;
    }
}
