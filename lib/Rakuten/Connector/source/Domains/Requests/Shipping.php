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

namespace RakutenConnector\Domains\Requests;

/**
 * Trait Shipping
 * @package RakutenConnector\Domains\Requests
 */
trait Shipping
{
    private $shipping;

    public function __construct()
    {
        $this->shipping = new \RakutenConnector\Domains\Shipping();
    }

    public function setShipping()
    {
        return new \RakutenConnector\Domains\Requests\Adapter\Shipping($this->shipping);
    }

    public function getShipping()
    {
        return $this->shipping;
    }
}
