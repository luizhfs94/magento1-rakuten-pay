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

namespace Rakuten\Connector\Domains\Requests\Shipping;

/**
 * Trait Cost
 * @package Rakuten\Connector\Domains\Requests\Shipping
 */
trait Cost
{
    private $cost;

    public function getCost()
    {
        return current($this->cost);
    }

    public function setCost()
    {
        $this->cost = new \Rakuten\Connector\Resources\Factory\Shipping\Cost($this->shipping);
        return $this->cost;
    }
}
