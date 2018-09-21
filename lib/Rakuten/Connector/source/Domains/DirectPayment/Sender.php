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

namespace RakutenConnector\Domains\DirectPayment;

/**
 * Direct Payment Sender
 *
 * @package RakutenConnector\Domains\Requests\DirectPayment
 */
class Sender extends \RakutenConnector\Domains\Sender
{
    /**
     * @var
     */
    private $ip;
    
    /**
     * @var
     */
    private $hash;
    
    /**
     * Sender constructor.
     */
    public function __construct()
    {
        parent::__construct();
        return $this;
    }
    
    /**
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     * @return Sender
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getHash()
    {
        return $this->hash;
    }

    /**
     * @param string $ip
     * @return Sender
     */
    public function setHash($hash)
    {
        $this->hash = $hash;
        return $this;
    }
}
