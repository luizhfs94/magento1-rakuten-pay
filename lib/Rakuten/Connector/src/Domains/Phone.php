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

namespace Rakuten\Connector\Domains;

/**
 * Class Phone
 * @package Rakuten\Connector\Domains
 */
class Phone
{
    /**
     * @var
     */
    private $areaCode;
    /**
     * @var
     */
    private $number;

    /**
     * @return integer
     */
    public function getAreaCode()
    {
        return $this->areaCode;
    }

    /**
     * @param integer $areaCode
     * @return Phone
     */
    public function setAreaCode($areaCode)
    {
        $this->areaCode = $areaCode;
        return $this;
    }

    /**
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param integer $number
     * @return Phone
     */
    public function setNumber($number)
    {
        $this->number = $number;
        return $this;
    }
}
